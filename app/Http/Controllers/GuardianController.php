<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Events\UserRegistered;
use App\ExamForClass;
use App\Http\Requests\CreateGuardianRequest;
use App\Http\Requests\UpdateGuardianRequest;
use App\Notification;
use App\Routine;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\Grade\GradeService;
use App\Services\User\UserService;
use App\StudentInfo;

;

use App\Syllabus;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuardianController extends Controller
{
    protected $userService;
    protected $courseService;
    protected $gradeService;
    protected $attendanceService;

    public function __construct(UserService $userService, CourseService $courseService, GradeService $gradeService, AttendanceService $attendanceService)
    {
        $this->userService = $userService;
        $this->courseService = $courseService;
        $this->gradeService = $gradeService;
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userService->getGuardians();

        return view('school.guardian.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('school.guardian.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGuardianRequest $request)
    {
        $path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-' . Auth::user()->school_id . '/' . date('Y'), $request->file('pic_path')) : null;
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'guardian', $path);

        if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            event(new UserRegistered($tb, $password));
        }

        return redirect()->route('all.guardian')->with('status', 'Guardian Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('school.guardian.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGuardianRequest $request, $id)
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myChild()
    {
        $users = StudentInfo::with('student.section.class')
            ->where('guardian_id', Auth::user()->id)
            ->paginate(20);

        return view('school.guardian.my-child', compact('users'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showByChildId($id)
    {
        $student = User::with(['studentInfo', 'section', 'section.class.feeMasters', 'section.class.feeMasters.feeType'])
            ->where('id', $id)
            ->first();

        // course section
        if ($this->courseService->isCourseOfASection($student->section_id)) {

            $courses = $this->courseService->getCoursesBySection($student->section_id);
        }

        // grades section
        $grades = $this->gradeService->getStudentGradesWithInfoCourseTeacherExam($id);
        $gradesystems = [];
        $exams = [];

        if (count($grades) > 0) {
            $exams = $this->gradeService->getExamByIdsFromGrades($grades);
            $gradesystems = $this->gradeService->getGradeSystemInfoBySchoolId();

        }

        $discounts = Discount::where('school_id', $student->school_id)->get();

        // syllabus section
        $class_id = $student->role == 'student' ? $student['section']['class_id'] : '';

        $syllabuses = Syllabus::with('myclass')
            ->where('school_id', $student->school_id)
            ->where('active', 1)
            ->when($class_id, function($query) use ($class_id) {
                return $query->where('class_id', $class_id);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(30);


        //routine section
        $section_id = $student->role == 'student' ? $student->section_id : '';
        $files = Routine::with('section.class')
            ->where('school_id', $student->school_id)
            ->where('active', 1)
            ->when($section_id, function ($query) use ($section_id) {
                $query->where('section_id', $section_id);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        //attendance section
        $present = 0;
        $absent = 0;
        $escaped = 0;
        $total = 0;

        $attCount = $this->attendanceService->getAllAttendanceByStudentId($id);
        foreach ($attCount as $att) {
            $total = $att->total_present + $att->total_absent + $att->total_escaped;
            $present = $att->total_present;
            $absent = $att->total_absent;
            $escaped = $att->total_escaped;
        }
        $exam = ExamForClass::where('class_id', $student->section->class->id)
            ->where('active', 1)
            ->first();

        $ex_id = isset($exam) ? $exam->exam_id : 0;

        $attendances = $this->attendanceService->getAttendanceByStudentAndExam($id, $ex_id);
        $student_id = $id;

        //message section
        $messages = Notification::with('teacher.department')->where('student_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        foreach ($messages as $m) {

            if ($m->active == 1) {
                $msg = Notification::findOrFail($m->id);
                $msg->active = 0;
                $msg->updated_at = now();
                $msg->save();
            }

        }
        return view('school.guardian.show-child', compact('courses', 'grades',
            'gradesystems', 'exams', 'student', 'discounts', 'files', 'section_id', 'syllabuses',
            'attendances', 'student_id', 'total', 'present', 'absent', 'escaped', 'messages'));

    }
}

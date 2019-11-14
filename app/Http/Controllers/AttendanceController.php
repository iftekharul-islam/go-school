<?php

namespace App\Http\Controllers;

use App\Course;
use App\Section;
use App\Attendance;
use App\ExamForClass;
use Illuminate\Http\Request;
use App\Http\Traits\GradeTrait;
use Illuminate\Support\Facades\Auth;
use App\Services\Attendance\AttendanceService;
use App\Http\Requests\Attendance\StoreAttendanceRequest;

class AttendanceController extends Controller
{
    use GradeTrait;

    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($section_id, $student_id, $exam_id)
    {
        $user = Auth::user();
        if ($section_id > 0 && 'student' != $user->role) {
            $students = $this->attendanceService->getStudentsBySection($section_id);
            $attendances = $this->attendanceService->getTodaysAttendanceBySectionId($section_id);
            $attCount = $this->attendanceService->getAllAttendanceBySecAndExam($section_id);

            return view('attendance.attendance', [
                'students' => $students,
                'attendances' => $attendances,
                'attCount' => $attCount,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
            ]);
        } else {
            $present = 0;
            $absent = 0;
            $escaped = 0;
            $total = 0;

            // View attendance of a single student by student id//

            if ('student' == $user->role) {
                $attCount = $this->attendanceService->getAllAttendanceByStudentId($student_id);
                foreach ($attCount as $att) {
                    $total = $att->total_present + $att->total_absent + $att->total_escaped;
                    $present = $att->total_present;
                    $absent = $att->total_absent;
                    $escaped = $att->total_escaped;
                }
                $exam = ExamForClass::where('class_id', $user->section->class->id)
                    ->where('active', 1)
                    ->first();
            } else {
                // From other users view
                $student = $this->attendanceService->getStudent($student_id);
                $attCount = $this->attendanceService->getAllAttendanceByStudentId($student_id);
                foreach ($attCount as $att) {
                    $total = $att->total_present + $att->total_absent + $att->total_escaped;
                    $present = $att->total_present;
                    $absent = $att->total_absent;
                    $escaped = $att->total_escaped;
                }
                if ($student) {
                    $exam = ExamForClass::where('class_id', $student->section->class->id)
                        ->where('active', 1)
                        ->first();
                }
            }
            if (isset($exam)) {
                $exId = $exam->exam_id;
            } else {
                $exId = 0;
            }
            $attendances = $this->attendanceService->getAttendanceByStudentAndExam($student_id, $exId);

            return view('attendance.admin-student-attendances', ['attendances' => $attendances, 'present' => $present, 'absent' => $absent, 'escaped' => $escaped, 'total' => $total]);
        }
    }

    /**
     * View for Adjust missing Attendances.
     *
     * @return \Illuminate\Http\Response
     */
    public function adjust($student_id)
    {
        $student = $this->attendanceService->getStudent($student_id);
        $exam = ExamForClass::where('class_id', $student->section->class->id)
            ->where('active', 1)
            ->first();
        if (1 == count((array) $exam)) {
            $exId = $exam->exam_id;
        } else {
            $exId = 0;
        }
        $attendances = $this->attendanceService->getAbsentAttendanceByStudentAndExam($student_id, $exId);

        return view('attendance.adjust', ['attendances' => $attendances, 'student_id' => $student_id]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *                                          Adjust missing Attendances POST request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adjustPost(Request $request)
    {
        $request->validate([
            'att_id' => 'required|array',
        ]);

        return $this->attendanceService->adjustPost($request);
    }

    /**
     * Add students to a Course before taking attendances.
     *
     * @return \Illuminate\Http\Response
     */
    public function addStudentsToCourseBeforeAtt($teacher_id, $course_id, $exam_id, $section_id)
    {
        $this->addStudentsToCourse($teacher_id, $course_id, $exam_id, $section_id);
        $students = $this->attendanceService->getStudentsBySection($section_id);
        $attendances = $this->attendanceService->getTodaysAttendanceBySectionId($section_id);
        $attCount = $this->attendanceService->getAllAttendanceBySecAndExam($section_id, $exam_id);

        return view('attendance.attendance', [
            'students' => $students,
            'attendances' => $attendances,
            'attCount' => $attCount,
            'section_id' => $section_id,
            'exam_id' => $exam_id,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *                                          View students of a section to view attendances
     *
     * @return \Illuminate\Http\Response
     */
    public function sectionIndex(Request $request, $section_id)
    {
        $users = $this->attendanceService->getStudentsWithInfoBySection($section_id);
        $request->session()->put('section-attendance', true);

        return view('list.new-student-list', [
            'users' => $users,
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
        ]);
    }

    public function attendanceDetails(Request $request, $section_id)
    {
        $course = Course::with('section')->where('section_id', $section_id)->first();
        $examID = 0;
        if (! empty($course->exam_id)) {
            $examID = $course->exam_id;
        }
        $users = $this->attendanceService->getStudentsWithInfoBySection($section_id);
        $students = $this->attendanceService->getStudentsBySection($section_id);
        $attCount = $this->attendanceService->getAllAttendanceBySecAndExam($section_id);
        $request->session()->put('section-attendance', true);
        if ($section_id > 0 && 'student' != Auth::user()->role) {
            $attendances = $this->attendanceService->getTodaysAttendanceBySectionId($section_id);

            return view('attendance.sectionAttendance', [
                'users' => $users,
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'attendances' => $attendances,
                'section_id' => $section_id,
                'students' => $students,
                'attCount' => $attCount,
                'exam_id' => $examID,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        $this->attendanceService->request = $request;
        if (1 == $request->update) {
            $at = $this->attendanceService->updateAttendance();
            if (isset($at)) {
                if (count($at) > 0) {
                    Attendance::insert($at);
                }
            }
        } else {
            $this->attendanceService->storeAttendance();
        }

        return back()->with('status', 'Attendance record updated');
    }
}

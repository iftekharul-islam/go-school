<?php

namespace App\Http\Controllers;

use App\Course;
use App\Exports\AbsentExport;
use App\Myclass;
use App\Section;
use App\Attendance;
use App\ExamForClass;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Traits\GradeTrait;
use Illuminate\Support\Facades\Auth;
use App\Services\Attendance\AttendanceService;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use Maatwebsite\Excel\Facades\Excel;

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
        $class = Myclass::where('school_id', Auth::user()->school_id)->first();
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

            return view('attendance.section-attendance', [
                'class' => $class,
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
    public function attendanceDetailsview(Request $request, $section_id)
    {
        $course = Course::with('section')->where('section_id', $section_id)->first();
        if (!$course)
        {
           return back()->with('error','No course is assigned for this section, Please assign a course first');
        }

        $examID = 0;
        if (! empty($course->exam_id)) {
            $examID = $course->exam_id;
        }
        $students = $this->attendanceService->getStudentsBySection($section_id);
        $attCount = $this->attendanceService->getAllAttendanceBySecAndExam($section_id);
        if ($section_id > 0 && 'student' != Auth::user()->role) {
            $attendances = $this->attendanceService->getTodaysAttendanceBySectionId($section_id);

            return view('attendance.student-section-attendance', [
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

     public function attendancesSummaryDate(Request $request, $section_id)
     {
         $s_date = $request->start_date;
         $start_display = date("d-m-Y", strtotime($s_date));
         $date = $request->end_date;
         $e_date = Carbon::parse($date)->addDays(1)->format('Y-m-d');
         $request->end_date = $e_date;
         $end_display =Carbon::parse($date)->format('d-m-Y');

         if (!$request->has('start_date') || !$request->filled('start_date')) {
             $start_date = Carbon::today()->addDays(-30)->format('Y-m-d');
             $start_display = date("d-m-Y", strtotime($start_date));;
             $request->start_date = $start_date;
         }
         if (!$request->has('end_date') || !$request->filled('end_date')) {
             $end_date = Carbon::today()->addDay(1)->format('Y-m-d');
             $end_display = Carbon::today()->format('d-m-Y');
             $request->end_date = $end_date;
         }
         $students = $this->attendanceService->getAttendanceSummary($request);

         $begin = new DateTime($request->start_date);
         $end = new DateTime($request->end_date);
         $interval = DateInterval::createFromDateString('1 day');
         $period = new DatePeriod($begin, $interval, $end);
         $final = [];
         foreach ($students as $student) {
               $final[$student->id] = [
                 "name" => $student->name,
             ];
               foreach ($period as $dt) {
                 $attendance = null;
                 if (isset($student['attendances'])) {
                     $attendance = $student->attendances->filter(function ($att) use($dt) {
                         return $att->created_at->format('Y-m-d') == $dt->format('Y-m-d');
                     })->first();
                 }
                 $final[$student->id]['attendances'][$dt->format('Y-m-d')] = $attendance ? $attendance->present : null;
             }
         }

        return view('attendance.attandence-summary', compact('final', 'start_display', 'end_display', 'students', 'period'));
     }

     public function absentExport($class_number, $section)
     {
         $date = carbon::today()->format('d_m_y');
         return Excel::download(new AbsentExport, 'Absent_Report-' . $date .'-class-' .$class_number. '-section-' . $section.'.xlsx');
     }
}

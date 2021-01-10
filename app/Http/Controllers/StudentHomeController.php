<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Event;
use App\Exam;
use App\Notice;
use App\Routine;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StudentHomeController extends Controller
{
    public function __construct(UserService $userService, User $user, CourseService $courseService, AttendanceService $attendanceService)
    {
        $this->userService = $userService;
        $this->user = $user;
        $this->middleware('auth');
        $this->courseService = $courseService;
        $this->attendanceService = $attendanceService;
    }
    public function index ()
    {
        $student = Auth::user();
        $minutes = 1440;// 24 hours = 1440 minutes
        if (isset($student->school_id)) {
            $school_id = $student->school_id;
            $notices = Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id) {
                return Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $events = Cache::remember('events-' . $school_id, $minutes, function () use ($school_id) {
                return Event::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $routines = Cache::remember('routines-' . $school_id, $minutes, function () use ($school_id) {
                return Routine::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });

            $exams = Cache::remember('exams-' . $school_id, $minutes, function () use ($school_id) {
                return Exam::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });

            $student_info = $student->studentInfo;
            $present=0;
            $absent=0;
            $escaped=0;
            $student_id = $student->id;
            $attCount = $this->attendanceService->getAllAttendanceByStudentId($student_id);
            if (!empty($attCount)) {
                foreach ($attCount as $att) {
                    $total =  $att->total_present + $att->total_absent + $att->total_escaped;
                    if ($total > 0)
                    {
                        $present = number_format(($att->total_present * 100) / $total, 2);
                        $absent = number_format(($att->total_absent * 100) / $total, 2);
                        $escaped = number_format(($att->total_escaped * 100) / $total, 2);
                    }
                }
            }
        }

        return view('dashboard', [

            'notices' => $notices,
            'events' => $events,
            'routines' => $routines,
            'exams' => $exams,
            'student_info' => $student_info,
            'student' => $student,
            'present' => $present,
            'absent' => $absent,
            'escaped' => $escaped
        ]);
    }
}

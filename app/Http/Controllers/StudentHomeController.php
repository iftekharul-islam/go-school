<?php

namespace App\Http\Controllers;

use App\Book;
use App\Event;
use App\Exam;
use App\Myclass;
use App\Notice;
use App\Routine;
use App\Section;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\Syllabus;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        if (@isset($student->school->id)) {
            $school_id = \Auth::user()->school->id;
            $classes = \Cache::remember('classes-' . $school_id, $minutes, function () use ($school_id) {
                return \App\Myclass::where('school_id', $school_id)
                    ->pluck('id')
                    ->toArray();
            });
            $totalStudents = \Cache::remember('totalStudents-'.$school_id, $minutes, function () use($school_id) {
                return User::where('school_id',$school_id)
                    ->where('role','student')
                    ->where('active', 1)
                    ->count();
            });
            $male = User::where('gender','male')->where('role', 'student')->where('school_id', Auth::user()->school_id)->count();
            $female = User::where('gender','female')->where('role', 'student')->where('school_id', Auth::user()->school_id)->count();
            $totalTeachers = \Cache::remember('totalTeachers-' . $school_id, $minutes, function () use ($school_id) {
                return User::where('school_id', $school_id)
                    ->where('role', 'teacher')
                    ->where('active', 1)
                    ->count();
            });
            $totalBooks = \Cache::remember('totalBooks-' . $school_id, $minutes, function () use ($school_id) {
                return Book::where('school_id', $school_id)->count();
            });
            $totalClasses = \Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)->count();
            });
            $totalSections = \Cache::remember('totalSections-' . $school_id, $minutes, function () use ($classes) {
                return Section::whereIn('class_id', $classes)->count();
            });
            $notices = \Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id) {
                return Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $events = \Cache::remember('events-' . $school_id, $minutes, function () use ($school_id) {
                return Event::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $routines = \Cache::remember('routines-' . $school_id, $minutes, function () use ($school_id) {
                return Routine::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $syllabuses = \Cache::remember('syllabuses-' . $school_id, $minutes, function () use ($school_id) {
                return Syllabus::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });

            $exams = \Cache::remember('exams-' . $school_id, $minutes, function () use ($school_id) {
                return Exam::where('school_id', $school_id)
                    ->where('active', 0)
                    ->get();
            });

            $student_info = \Auth::user()->studentInfo;
            $present=0;
            $absent=0;
            $escaped=0;
            $student_id = Auth::id();
            $attCount = $this->attendanceService->getAllAttendanceByStudentId($student_id);
            if (!empty($attCount)) {
                foreach ($attCount as $att) {
                    $total =  $att->totalPresent + $att->totalAbsent + $att->totalEscaped;
                    if ($total > 0)
                    {
                        $present = ($att->totalPresent * 100) / $total;
                        $absent = ($att->totalAbsent * 100) / $total;
                        $escaped = ($att->totalEscaped * 100) / $total;
                    }
                }
            }
        }

        return view('dashboard', [
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalBooks' => $totalBooks,
            'totalClasses' => $totalClasses,
            'totalSections' => $totalSections,
            'notices' => $notices,
            'events' => $events,
            'routines' => $routines,
            'syllabuses' => $syllabuses,
            'exams' => $exams,
            'student_info' => $student_info,
            'student' => $student,
            'male' => $male,
            'female' => $female,
            'present' => $present,
            'absent' => $absent,
            'escaped' => $escaped
        ]);
    }
}

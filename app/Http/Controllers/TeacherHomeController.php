<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Myclass;
use App\Notice;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherHomeController extends Controller
{
    public function __construct(UserService $userService, User $user, CourseService $courseService, AttendanceService $attendanceService)
    {
        $this->userService = $userService;
        $this->user = $user;
        $this->middleware('auth');
        $this->courseService = $courseService;
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $student = Auth::user();
        $minutes = 1440;// 24 hours = 1440 minutes
        if (@isset($student->school->id)) {
            $school_id = \Auth::user()->school->id;
            $classes = \Cache::remember('classes-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)
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

            $totalClasses = \Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)->count();
            });
            $totalSections = \Cache::remember('totalSections-' . $school_id, $minutes, function () use ($classes) {
                return \App\Section::whereIn('class_id', $classes)->count();
            });
            $notices = \Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id) {
                return Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });

            $exams = \Cache::remember('exams-' . $school_id, $minutes, function () use ($school_id) {
                return Exam::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
        }
        $courses_student = $this->courseService->getCoursesByTeacher($student->id);
        $allStudents = $this->userService->getStudents();
        return view('teacher-home', [
            'totalStudents' => $totalStudents,
            'allStudents' => $allStudents,
            'notices' => $notices,
            'exams' => $exams,
            'totalClasses' => $totalClasses,
            'totalSections' => $totalSections,
            'male' => $male,
            'female' => $female,
            'courses_student' => $courses_student
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\Attendance\AttendanceService;
use App\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Services\User\UserService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, User $user)
    {
        $this->userService = $userService;
        $this->user = $user;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
                return \App\User::where('school_id',$school_id)
                    ->where('role','student')
                    ->where('active', 1)
                    ->count();
            });
            $male = \App\User::where('gender','male')->count();
            $female = \App\User::where('gender','female')->count();
            $totalTeachers = \Cache::remember('totalTeachers-' . $school_id, $minutes, function () use ($school_id) {
                return \App\User::where('school_id', $school_id)
                    ->where('role', 'teacher')
                    ->where('active', 1)
                    ->count();
            });
            $totalBooks = \Cache::remember('totalBooks-' . $school_id, $minutes, function () use ($school_id) {
                return \App\Book::where('school_id', $school_id)->count();
            });
            $totalClasses = \Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
                return \App\Myclass::where('school_id', $school_id)->count();
            });
            $totalSections = \Cache::remember('totalSections-' . $school_id, $minutes, function () use ($classes) {
                return \App\Section::whereIn('class_id', $classes)->count();
            });
            $notices = \Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id) {
                return \App\Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $events = \Cache::remember('events-' . $school_id, $minutes, function () use ($school_id) {
                return \App\Event::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $routines = \Cache::remember('routines-' . $school_id, $minutes, function () use ($school_id) {
                return \App\Routine::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $syllabuses = \Cache::remember('syllabuses-' . $school_id, $minutes, function () use ($school_id) {
                return \App\Syllabus::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $exams = \Cache::remember('exams-' . $school_id, $minutes, function () use ($school_id) {
                return \App\Exam::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
        }

        if (\Auth::user()->role == 'master') {
            return view('master-home');
        }
        elseif (\Auth::user()->role == 'teacher' || \Auth::user()->role == 'accountant' || \Auth::user()->role == 'librarian' || \Auth::user()->role == 'admin' ) {
            $allStudents = $this->userService->getStudents();
//            return $allStudents;
            return view('teacher-home', [
                'totalStudents' => $totalStudents,
                'allStudents' => $allStudents,
                'notices' => $notices,
                'exams' => $exams,
                'totalClasses' => $totalClasses,
                'totalSections' => $totalSections,
                'male' => $male,
                'female' => $female
            ]);
        }
        else {
            $student_info = \Auth::user()->studentInfo;
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
                'student' => $student
                //'messageCount'=>$messageCount,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Book;
use App\Myclass;
use App\Notice;
use App\Section;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class LibrarianHomeController extends Controller
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
        if (isset($student->school->id)) {
            $school_id = Auth::user()->school->id;
            $classes = Cache::remember('classes-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)
                    ->pluck('id')
                    ->toArray();
            });

            $male = User::where('gender','male')->where('role', 'student')->where('school_id', Auth::user()->school_id)->count();
            $female = User::where('gender','female')->where('role', 'student')->where('school_id', Auth::user()->school_id)->count();
            $totalStudents = $female + $male;
            $totalClasses = Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)->count();
            });
            $totalSections = Cache::remember('totalSections-' . $school_id, $minutes, function () use ($classes) {
                return Section::whereIn('class_id', $classes)->count();
            });
            $notices = Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id) {
                return Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
            $exams = Cache::remember('exams-' . $school_id, $minutes, function () use ($school_id) {
                return Exam::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
        }
        $books = Book::bySchool(auth()->user()->school_id)->paginate();
        return view('teacher-home', [
            'totalStudents' => $totalStudents,
            'notices' => $notices,
            'exams' => $exams,
            'totalClasses' => $totalClasses,
            'totalSections' => $totalSections,
            'male' => $male,
            'female' => $female,
            'books' => $books
        ]);
    }
}

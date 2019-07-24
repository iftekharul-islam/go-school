<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Book;
use App\Exam;
use App\Http\Traits\GradeTrait;
use App\Myclass;
use App\Notice;
use App\School;
use App\Section;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\StudentInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Services\User\UserService;
use Alert;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use GradeTrait;
    protected $courseService;
    public function __construct(UserService $userService, User $user, CourseService $courseService, AttendanceService $attendanceService)
    {
        $this->userService = $userService;
        $this->user = $user;
        $this->middleware('auth');
        $this->courseService = $courseService;
        $this->attendanceService = $attendanceService;
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

        if (isset($student->school->id)) {
            $school_id = \Auth::user()->school->id;
//            $classes = \Cache::remember('classes-' . $school_id, $minutes, function () use ($school_id) {
            $classes = Myclass::where('school_id', $school_id)
                ->pluck('id')
                ->toArray();
//            });
//            $totalStudents = \Cache::remember('totalStudents-'.$school_id, $minutes, function () use($school_id) {
            $totalStudents = User::where('school_id',$school_id)
                ->where('role','student')
                ->where('active', 1)
                ->count();
//            });
            $male = User::where('gender','male')->where('role', 'student')->where('school_id', Auth::user()->school_id)->count();
            $female = User::where('gender','female')->where('role', 'student')->where('school_id', Auth::user()->school_id)->count();

//            $totalClasses = \Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
            $totalClasses =  Myclass::where('school_id', $school_id)->count();
//            });
//            $totalSections = \Cache::remember('totalSections-' . $school_id, $minutes, function () use ($classes) {
            $totalSections = Section::whereIn('class_id', $classes)->count();
//            });
//            $notices = \Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id) {
            $notices = Notice::where('school_id', $school_id)
                ->where('active', 1)
                ->get();
//            });
//            $exams = \Cache::remember('exams-' . $school_id, $minutes, function () use ($school_id) {
            $exams = Exam::where('school_id', $school_id)
                ->where('active', 1)
                ->get();
//            });
        }

        $allStudents = $this->userService->getStudents();
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
}

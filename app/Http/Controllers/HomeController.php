<?php

namespace App\Http\Controllers;


use App\Exam;
use App\Http\Traits\GradeTrait;
use App\Myclass;
use App\Notice;
use App\Section;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Services\User\UserService;
use Alert;
use Illuminate\Support\Facades\Cache;


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
     * @name index
     * @description sends auth users school information related to auth admin users dashboard
     * @return \Illuminate\Http\Response
     *
     */
    public function index()
    {
        $admin = Auth::user();
        $minutes = 1440;// 24 hours = 1440 minutes

        if (isset($admin->school->id)) {
            $school_id = $admin->school->id;
            $classes = Cache::remember('classes-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)
                    ->pluck('id')
                    ->toArray();
            });

            $students = User::where('role', 'student')->where('school_id', $admin->school_id)->where('active',1)->get();
            $male = 0;
            $female = 0;
            foreach($students as $std)
            {
                if (strtolower($std['gender']) == 'male') {
                    $male++;
                } else {
                    $female++;
                }
            }
            $totalStudents = $male + $female;
            $totalClasses = Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
                return  Myclass::where('school_id', $school_id)->count();
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

<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Fee;
use App\Myclass;
use App\Notice;
use App\Section;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AccountantHomeController extends Controller
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
        $minutes = 1440;

        if (isset($student->school->id)) {
            $school_id = Auth::user()->school->id;
            $classes = Cache::remember('classes-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)
                    ->pluck('id')
                    ->toArray();
            });
            $totalStudents = Cache::remember('totalStudents-'.$school_id, $minutes, function () use($school_id) {
                return User::where('school_id',$school_id)
                    ->where('role','student')
                    ->where('active', 1)
                    ->count();
            });
            $male = User::where('gender','male')->where('role', 'student')->where('school_id', Auth::user()->school_id)->count();
            $female = User::where('gender','female')->where('role', 'student')->where('school_id', Auth::user()->school_id)->count();

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
                    ->where('active', 0)
                    ->get();
            });
        }

        $total_expense = DB::table('accounts')->where('type', 'expense')
            ->selectRaw('sum(amount)')
            ->get();
        foreach ($total_expense as $te)
            $total_expense = $te->sum;

        $total_income = DB::table('accounts')->where('type', 'income')
            ->selectRaw('sum(amount)')
            ->get();

        foreach ($total_income as $ti)
            $total_income = $ti->sum;

        $fees = Fee::where('school_id', Auth::user()->school_id)->get();
        return view('accountant-home', [
            'totalStudents' => $totalStudents,
            'notices' => $notices,
            'exams' => $exams,
            'totalClasses' => $totalClasses,
            'totalSections' => $totalSections,
            'male' => $male,
            'female' => $female,
            'fees'   => $fees,
            'total_income' => $total_income,
            'total_expense' => $total_expense,
        ]);
    }
}

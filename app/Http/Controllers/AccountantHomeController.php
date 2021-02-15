<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Fee;
use App\FeeTransaction;
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
            $totalStudents = Cache::remember('totalStudents-' . $school_id, $minutes, function () use ($school_id) {
                return User::where('school_id', $school_id)
                    ->where('role', 'student')
                    ->where('active', 1)
                    ->count();
            });

            $totalClasses = Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)->count();
            });
            $totalSections = Cache::remember('totalSections-' . $school_id, $minutes, function () use ($classes) {
                return Section::whereIn('class_id', $classes)->count();
            });
            $notices = Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id, $student) {
                return Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->orderBy('created_at', 'DESC')
                    ->selectedRole()
                    ->orWhere('roles', null)
                    ->get();
            });

            $exams = Cache::remember('exams-' . $school_id, $minutes, function () use ($school_id) {
                return Exam::where('school_id', $school_id)
                    ->where('active', 1)
                    ->get();
            });
        }

        $total_expense = DB::table('accounts')->where('type', 'expense')
            ->where('school_id', Auth::user()->school_id)
            ->selectRaw('sum(amount)')
            ->get();
        foreach ($total_expense as $te)
            $total_expense = $te->sum;

        $total_income = DB::table('accounts')->where('type', 'income')
            ->where('school_id', Auth::user()->school_id)
            ->selectRaw('sum(amount)')
            ->get();

        foreach ($total_income as $ti)
            $total_income = $ti->sum;


        $student_amount = FeeTransaction::where('school_id', \auth()->user()->school_id)->sum('amount');
        $student_discount = FeeTransaction::where('school_id', \auth()->user()->school_id)->sum('discount');
        $student_fine = FeeTransaction::where('school_id', \auth()->user()->school_id)->sum('fine');
        $student_total = $student_amount - $student_fine + $student_discount;
        $total_income = $total_income + $student_total;

        $fees = Fee::where('school_id', Auth::user()->school_id)->get();
        return view('accountant_home', [
            'totalStudents' => $totalStudents,
            'notices' => $notices,
            'exams' => $exams,
            'totalClasses' => $totalClasses,
            'totalSections' => $totalSections,
            'fees' => $fees,
            'total_income' => $total_income,
            'total_expense' => $total_expense,
        ]);
    }
}

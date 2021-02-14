<?php

namespace App\Http\Controllers;

use App\Myclass;
use App\Notice;
use App\Section;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GuardianHomeController extends Controller
{
    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * GuardianHomeController constructor.
     * @param UserService $userService
     * @param User $user
     * @param CourseService $courseService
     * @param AttendanceService $attendanceService
     */
    public function __construct(UserService $userService, User $user, CourseService $courseService, AttendanceService $attendanceService)
    {
        $this->userService = $userService;
        $this->user = $user;
        $this->middleware('auth');
        $this->courseService = $courseService;
        $this->attendanceService = $attendanceService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $guardian = Auth::user();
        $minutes = 1440;// 24 hours = 1440 minutes

        if (isset($guardian->school->id)) {
            $school_id = $guardian->school->id;
            $classes = Cache::remember('classes-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)
                    ->pluck('id')
                    ->toArray();
            });

            $students = User::where('role', 'student')->where('school_id', $guardian->school_id)->where('active',1)->get();
            $teachers = User::where('role', 'teacher')->where('school_id', $guardian->school_id)->where('active',1)->get();
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
            $total_classes = Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
                return  Myclass::where('school_id', $school_id)->count();
            });
            $total_sections = Cache::remember('totalSections-' . $school_id, $minutes, function () use ($classes) {
                return Section::whereIn('class_id', $classes)->count();
            });
            $notices = Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id, $guardian) {
                return Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->orderBy('created_at', 'DESC')
                    ->where('roles', 'like', "%\"{$guardian->role}\"%")
                    ->orWhere('roles', null)
                    ->get();
            });

        }

        $all_students = $this->userService->getStudents();

        return view('guardian_home', [
            'students' => $students,
            'allStudents' => $all_students,
            'notices' => $notices,
            'totalClasses' => $total_classes,
            'totalSections' => $total_sections,
            'male' => $male,
            'female' => $female,
            'teachers' => $teachers,
        ]);

    }
}

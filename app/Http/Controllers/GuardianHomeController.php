<?php

namespace App\Http\Controllers;

use App\Myclass;
use App\Notice;
use App\Section;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\StudentInfo;
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
            $notices = Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id) {
                return Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->orderBy('created_at', 'DESC')
                    ->selectedRole()
                    ->orWhere('roles', null)
                    ->get();
            });
            $events = Cache::remember('events-' . $school_id, $minutes, function () use ($school_id) {
                return Notice::where('school_id', $school_id)
                    ->where('active', 1)
                    ->orderBy('created_at', 'DESC')
                    ->selectedRole()
                    ->orWhere('roles', null)
                    ->get();
            });

            $users = StudentInfo::with('student.section.class')
                ->where('guardian_id', $guardian->id)
                ->paginate(20);

        }

        return view('guardian_home', [
            'notices' => $notices,
            'events' => $events,
            'users' => $users
        ]);

    }
}

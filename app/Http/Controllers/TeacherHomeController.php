<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Myclass;
use App\Notice;
use App\Section;
use App\Services\Attendance\AttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        $teacher = Auth::user();
        $minutes = 1440;// 24 hours = 1440 minutes
        if (isset($teacher->school->id)) {
            $school_id = $teacher->school->id;
            $classes = Cache::remember('classes-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)
                    ->pluck('id')
                    ->toArray();
            });

            $students = User::where('role', 'student')->where('school_id', $teacher->school_id)->where('active',1)->get();
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
            $totalClasses = Cache::remember('totalClasses-' . $school_id, $minutes, function () use ($school_id) {
                return Myclass::where('school_id', $school_id)->count();
            });
            $totalSections = Cache::remember('totalSections-' . $school_id, $minutes, function () use ($classes) {
                return Section::whereIn('class_id', $classes)->count();
            });
            $notices = Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id, $teacher) {
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
        return view('teacher_home', [
            'students' => $students,
            'notices' => $notices,
            'exams' => $exams,
            'totalClasses' => $totalClasses,
            'totalSections' => $totalSections,
            'male' => $male,
            'female' => $female,
        ]);
    }
    public function myStudent()
    {
        $teacher = Auth::user();
        $student_courses = $this->courseService->getCoursesByTeacher($teacher->id);

        return view('school.teachers_student_list', compact('student_courses'));
    }
}

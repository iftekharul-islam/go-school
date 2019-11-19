<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use App\School;
use App\Department;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\Course\CourseService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateAdminRequest;
use App\Services\Attendance\AttendanceService;
use App\Services\Attendance\TeacherAttendanceService;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $userService;
    protected $user;

    public function __construct(UserService $userService, User $user, AttendanceService $attendanceService, TeacherAttendanceService $teacherAttendanceService, CourseService $courseService)
    {
        $this->userService = $userService;
        $this->user = $user;
        $this->attendanceService = $attendanceService;
        $this->teacherAttendanceService = $teacherAttendanceService;
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        $users = User::where('name', 'ilike', "%{$request->input('search')}%")
            ->where('school_id', Auth::user()->school_id)
            ->where('role', '!=', 'admin')
            ->get();

        return view('search.search-list', compact('users'));
    }

    public function search($id)
    {
        $user = User::findOrFail($id);
        $user_info = '';
        $present = 0;
        $absent = 0;
        $escaped = 0;
        if ('student' == $user->role) {
            $section = $user->section;
            $student_id = $user->id;
            $attCount = $this->attendanceService->getAllAttendanceByStudentId($student_id);
            if (! empty($attCount)) {
                foreach ($attCount as $att) {
                    $total = $att->total_present + $att->total_absent + $att->total_escaped;
                    if ($total > 0) {
                        $present = number_format(($att->total_present * 100) / $total, 2);
                        $absent = number_format(($att->total_absent * 100) / $total, 2);
                        $escaped = number_format(($att->total_escaped * 100) / $total, 2);
                    }
                }
            }
            $courses = Course::with(['section', 'teacher'])
                ->where('section_id', $user->section_id)
                ->get();

            return view('search.search-result', compact('user', 'user_info', 'section', 'present', 'absent', 'escaped', 'courses'));
        } else {
            $present = 0;
            $absent = 0;
            $courses = 0;
            $attCount = $this->teacherAttendanceService->getAllAttendanceByStuffId($user->id);
            if ($attCount) {
                foreach ($attCount as $att) {
                    $total = $att->total_present + $att->total_absent;
                    $present = number_format(($att->total_present * 100) / $total, 2);
                    $absent = number_format(($att->total_absent * 100) / $total, 2);
                }
                if ('teacher' == $user->role) {
                    $courses = $this->courseService->getCoursesByTeacherId($user->id);
                }
            }

            return view('search.other-role', compact('user', 'present', 'absent', 'courses'));
        }
    }

    public function findUser(Request $request)
    {
        $data = User::where('name', 'ilike', "%{$request->input('query')}%")
            ->where('school_id', Auth::user()->school_id)
            ->where('role', '!=', 'admin')
            ->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $departments = Department::where('school_id', $id)->get();

        return view('auth.admin', compact('id', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdminRequest $request)
    {
        $school = School::where('id', $request->school_id)->first();
        $request->request->add(['code' => $school->code]);
        $password = $request->password;
        $pic_path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('pic_path')) : null;
        $tb = $this->userService->storeAdmin($request, $pic_path);
        $tb->adminDepartments()->sync($request->departments);

        try {
            event(new UserRegistered($tb, $password));
        } catch (\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->with('status', 'Admin Created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
        $departments = Department::where('school_id', $user->school_id)->get();

        return view('auth.admin-edit', compact('user', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $tb = $this->user->findOrFail($request->user_id);
        $tb->name = $request->name;
        $tb->email = (! empty($request->email)) ? $request->email : '';
        $tb->nationality = (! empty($request->nationality)) ? $request->nationality : '';
        $tb->blood_group = $request->blood_group;
        $tb->phone_number = $request->phone_number;
        $tb->address = (! empty($request->address)) ? $request->address : '';
        $tb->adminDepartments()->sync($request->departments);
        $tb->about = (! empty($request->about)) ? $request->about : '';
        $tb->pic_path = $request->hasFile('pic_path') ? 'storage/'.Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('pic_path')) : $tb->pic_path;
        $tb->save();

        return back()->with('status', $request->name.' User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = $this->user->findOrFail($id);
        if (0 !== $admin->active) {
            $admin->active = 0;
        } else {
            $admin->active = 1;
        }

        $admin->save();

        return back()->with('status', $admin->name.' active status changed');
    }
}

<?php

namespace App\Http\Controllers;

use App\Course;
use App\Events\StudentInfoUpdateRequested;
use App\Events\UserRegistered;
use App\Grade;
use App\Gradesystem;
use App\GradeSystemInfo;
use App\Http\Requests\User\CreateAdminRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\School;
use App\Services\Attendance\AttendanceService;
use App\Services\Attendance\TeacherAttendanceService;
use App\Services\Course\CourseService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $userService;
    protected $user;

    public function __construct(UserService $userService, User $user, AttendanceService $attendanceService, TeacherAttendanceService $teacherAttendanceService, CourseService $courseService){
        $this->userService = $userService;
        $this->user = $user;
        $this->attendanceService = $attendanceService;
        $this->teacherAttendanceService = $teacherAttendanceService;
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        $users = User::where("name","ilike","%{$request->input('search')}%")
            ->where('school_id', Auth::user()->school_id)
            ->where('role', '!=', 'admin')
            ->get();
//        return $users;
        return view('search.search-list', compact('users'));
    }

    public function search($id)
    {
        $user = User::findOrFail($id);
        $user_info = '';
        $present=0;
        $absent=0;
        $escaped=0;
        if ($user->role == 'student')
        {
            $section = $user->section;
            $student_id = $user->id;
            $attCount = $this->attendanceService->getAllAttendanceByStudentId($student_id);
            if (!empty($attCount)) {
                foreach ($attCount as $att) {
                    $total =  $att->total_present + $att->total_absent + $att->total_escaped;
                    if ($total > 0)
                    {
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
            $absent= 0;
            $total= 0;
            $courses = 0;
            $attCount = $this->teacherAttendanceService->getAllAttendanceByStuffId($user->id);
            if ($attCount) {
                foreach ($attCount as $att) {
                    $total =  $att->total_present + $att->total_absent;
                    $present = number_format(($att->total_present * 100) / $total, 2);
                    $absent = number_format(($att->total_absent * 100) / $total, 2);
                }
                if ($user->role == 'teacher')
                {
                    $courses = $this->courseService->getCoursesByTeacherId($user->id);
                }
//                return $courses;
            }
            return view('search.other-role', compact('user', 'present', 'absent', 'courses'));
        }
    }

    public function findUser(Request $request)
    {
        $data = User::where("name","ilike","%{$request->input('query')}%")
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
        return view('auth.admin', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdminRequest $request)
    {
        $school = School::where('id', $request->school_id)->first();
        $request->request->add(['code' => $school->code]);
        $password = $request->password;
        $tb = $this->userService->storeAdmin($request);
        try {
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->with('status', 'Admin Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
        return view('auth.admin-edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $tb = $this->user->findOrFail($request->user_id);
        $tb->name = $request->name;
        $tb->email = (!empty($request->email)) ? $request->email : '';
        $tb->nationality = (!empty($request->nationality)) ? $request->nationality : '';
        $tb->phone_number = $request->phone_number;
        $tb->address = (!empty($request->address)) ? $request->address : '';
        $tb->about = (!empty($request->about)) ? $request->about : '';
        $tb->pic_path = (!empty($request->pic_path)) ? $request->pic_path : '';
        $tb->save();

        return back()->with('status', $request->name. ' User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = $this->user->findOrFail($id);
        if ($admin->active !== 0) {
            $admin->active = 0;
        } else {
            $admin->active = 1;
        }

        $admin->save();

        return back()->with('status', $admin->name.' active status changed');
    }
}

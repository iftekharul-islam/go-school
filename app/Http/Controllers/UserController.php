<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\UpdateStaffProfileRequest;
use App\StudentInfo;
use App\User;
use App\Myclass;
use App\Section;
use App\Department;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Events\StudentInfoUpdateRequested;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateAdminRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\User\CreateTeacherRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\CreateLibrarianRequest;
use App\Http\Requests\User\ImpersonateUserRequest;
use App\Http\Requests\User\CreateAccountantRequest;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    protected $userService;
    protected $user;

    public function __construct(UserService $userService, User $user)
    {
        $this->userService = $userService;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $school_code
     * @param $student_code
     * @param $teacher_code
     *
     * @return \Illuminate\Http\Response
     */
    public function index($school_code, $student_code, $teacher_code)
    {
        session()->forget('section-attendance');
        if ($this->userService->isListOfStudents($school_code, $student_code)) {
            return $this->userService->indexView('list.new-student-list', $this->userService->getStudents(), $type = 'Students');
        } elseif ($this->userService->isListOfTeachers($school_code, $teacher_code)) {
            return $this->userService->indexView('list.new-teacher-list', $this->userService->getTeachers(), $type = 'Teachers');
        } else {
            return view('home');
        }
    }

    /**
     * @param $school_code
     * @param $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexOther($school_code, $role)
    {
        if ($this->userService->isAccountant($role)) {
            return $this->userService->indexOtherView('accounts.new-accountant-list', $this->userService->getAccountants());
        } elseif ($this->userService->isLibrarian($role)) {
            return $this->userService->indexOtherView('library.new-librarian-list', $this->userService->getLibrarians());
        } else {
            return view('home');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToRegisterStudent()
    {
        $classes = Myclass::query()
            ->where('school_id', Auth::user()->school->id)
            ->pluck('id');

        $sections = Section::with('class')
            ->whereIn('class_id', $classes)
            ->get();

        session([
            'register_role' => 'student',
            'register_sections' => $sections,
        ]);

        return view('auth.student', [
            'classes' => $classes,
            session(['register_role' => 'student', 'register_sections' => $sections]),
        ]);
    }

    /**
     * @param $section_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sectionStudents($section_id)
    {
        $students = $this->userService->getSectionStudentsWithSchool($section_id);

        return view('profile.new-section-students', compact('students'));
    }

    /**
     * @param $section_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function promoteSectionStudents($section_id)
    {
        if ($this->userService->hasSectionId($section_id)) {
            return $this->userService->promoteSectionStudentsView(
                $this->userService->getSectionStudentsWithStudentInfo($section_id),
                Myclass::with('sections')->where('school_id', Auth::user()->school_id)->get(),
                $section_id
            );
        } else {
            return $this->userService->promoteSectionStudentsView([], [], $section_id);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function promoteSectionStudentsPost(Request $request)
    {
        return $this->userService->promoteSectionStudentsPost($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\
     *                                                              View
     */
    public function changePasswordGet()
    {
        return view('profile.new-change-password');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePasswordPost(ChangePasswordRequest $request)
    {
        if (! (Hash::check($request->get('current-password'), Auth::user()->password))) {
            return back()->with('error-status', 'Current password do not match');
        }
        if (0 == strcmp($request->get('current-password'), $request->get('password'))) {
            return redirect()->back()->with('error-status', 'New Password cannot be same as your current password. Please choose a different password.');
        }
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return back()->with('status', 'Password updated');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function impersonateGet()
    {
        if (app('impersonate')->isImpersonating()) {
            Auth::user()->leaveImpersonation();

            return redirect('master/home');
        } else {
            return view('profile.impersonate', [
                'other_users' => $this->user->where('id', '!=', auth()->id())->get(['id', 'name', 'role']),
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function impersonate(ImpersonateUserRequest $request)
    {
        $user = $this->user->findOrFail($request->id);
        Auth::user()->impersonate($user);

        return redirect($user->role.'/home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $path = $request->hasFile('student_pic') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('student_pic')) : null;
        $password = $request->password;
        $tb = $this->userService->storeStudent($request, $path);
        $this->userService->storeStudentInfo($request, $tb);
        event(new UserRegistered($tb, $password));
        return back()->withInput(['tab' => 'tab12'])->with('status', 'New Student Added!');
    }

    /**
     * @param CreateAdminRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAdmin()
    {
        return view('auth.admin');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeTeacher(CreateTeacherRequest $request)
    {
        $path = $request->hasFile('teacher_pic') ? Storage::disk('public')->put('school-'.Auth::user()->school_id.'/'.date('Y'), $request->file('teacher_pic')) : null;
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'teacher', $path);
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch (\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->withInput(['tab' => 'tab13'])->with('status', 'Teacher Created');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAccountant(CreateAccountantRequest $request)
    {
        $path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('pic_path')) : null;
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'accountant', $path);
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch (\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->withInput(['tab' => 'tab10'])->with('status', 'Accountant created');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLibrarian(CreateLibrarianRequest $request)
    {
        $path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('pic_path')) : null;
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'librarian', $path);
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch (\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->withInput(['tab' => 'tab11'])->with('status', 'Librarian Created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $user_code ( Student_Code )
     *
     * @return UserResource
     */
    public function show($user_code)
    {
        $user = $this->userService->getUserByUserCode($user_code);

        return view('profile.user-profile', compact('user'));
    }

    public function editUserInfo($user_code)
    {
        $user = User::with('studentInfo')->where('id', $user_code)->firstOrFail();
        if ($user->role == 'student') {
            return view('profile.edit-student-info', compact('user'));
        } else {
            return view('profile.authority-member-info-edit', compact('user'));
        }
    }

    public function updateUserInfo(Request $request, $user_code)
    {

        // return $request->all();
        $tb = $this->user->findOrFail($user_code);
        $path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('pic_path')) : $tb->pic_path;
        $image_path = 'storage/'.$path;
        $tb->name = $request->name;
        $tb->address = (! empty($request->address)) ? $request->address : $tb->address;
        $tb->about = (! empty($request->about)) ? $request->about : $tb->about;
        $tb->pic_path = (empty($request->pic_path)) ? $tb->pic_path : $image_path;
        $tb->blood_group = (! empty($request->blood_group)) ? $request->blood_group : $tb->blood_group;
        $tb->gender = (! empty($request->gender)) ? $request->gender : $tb->gender;
        if ($tb->save()) {
            $info = StudentInfo::firstOrCreate(['user_id' => $tb->id]);
            $info->religion = (!empty($request->religion)) ? $request->religion : $info->religion;
            $info->father_name = (!empty($request->father_name)) ? $request->father_name : $info->father_name;
            $info->father_designation = (!empty($request->father_designation)) ? $request->father_designation : $info->father_designation;
            $info->mother_name = (!empty($request->mother_name)) ? $request->mother_name : $info->mother_name;
            $info->mother_occupation = (!empty($request->mother_occupation)) ? $request->mother_occupation : $info->mother_occupation;
            $info->father_occupation = (!empty($request->father_occupation)) ? $request->father_occupation : $info->father_occupation;
            $info->mother_designation = (!empty($request->mother_designation)) ? $request->mother_designation : $info->mother_designation;

            $info->is_sms_enabled = $request->sms_enabled == 'true' ? true : false;
            $info->user_id = auth()->user()->id;
            $info->save();
        }

        return back()->with('status', $request->name.' Information Updated');

    }
    public function updateStaffInformation(UpdateStaffProfileRequest $request, $user_code) {
        $tb = $this->user->findOrFail($user_code);
        $path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('pic_path')) : $tb->pic_path;
        $image_path = 'storage/'.$path;
        $tb->name = $request->name;
        $tb->address = (! empty($request->address)) ? $request->address : $tb->address;
        $tb->about = (! empty($request->about)) ? $request->about : $tb->about;
        $tb->pic_path = (empty($request->pic_path)) ? $tb->pic_path : $image_path;
        $tb->blood_group = (! empty($request->blood_group)) ? $request->blood_group : $tb->blood_group;
        $tb->gender = (! empty($request->gender)) ? $request->gender : $tb->gender;
        $tb->save();
        return back()->with('status', $request->name.' Information Updated');
    }

    /**
     * Show the form for
     * ing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
        $classes = Myclass::query()
            ->where('school_id', Auth::user()->school_id)
            ->pluck('id')
            ->toArray();

        $sections = Section::query()
            ->whereIn('class_id', $classes)
            ->get();

        $departments = Department::query()
            ->where('school_id', Auth::user()->school_id)
            ->get();

        return view('profile.new-edit', [
            'user' => $user,
            'sections' => $sections,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        // return $request->all();
        $path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('pic_path')) : null;
        $image_path = 'storage/'.$path;
        DB::transaction(function () use ($request, $image_path) {
            $tb = $this->user->findOrFail($request->user_id);
            $tb->name = $request->name;
            $tb->email = (! empty($request->email)) ? $request->email : $tb->email;
            $tb->nationality = (! empty($request->nationality)) ? $request->nationality : $tb->nationality;
            $tb->phone_number = $request->phone_number;
            $tb->address = (! empty($request->address)) ? $request->address : $tb->address;
            $tb->about = (! empty($request->about)) ? $request->about : $tb->about;
            $tb->pic_path = (empty($request->pic_path)) ? $tb->pic_path : $image_path;
            $tb->blood_group = (! empty($request->blood_group)) ? $request->blood_group : $tb->blood_group;
            $tb->gender = (! empty($request->gender)) ? $request->gender : $tb->gender;
            if ('teacher' == $request->user_role) {
                $tb->department_id = $request->department_id;
                $tb->section_id = $request->class_teacher_section_id;
            }
            if ($tb->save()) {
                if ($request->user_role == 'student') {
                    $info = StudentInfo::firstOrCreate(['user_id' => $tb->id]);
                    $info->student_id = $tb->student_code;
                    $info->session = $request->get('session');
                    $info->version =$request->get('version');
                    $info->group = $request->get('group');
                    $info->birthday = $request->get('birthday');
                    $info->religion = $request->get('religion');
                    $info->father_name = $request->get('father_name');
                    $info->father_phone_number = $request->get('father_phone_number');
                    $info->father_national_id = $request->get('father_national_id');
                    $info->father_occupation = $request->get('father_occupation');
                    $info->father_designation = $request->get('father_designation');
                    $info->father_annual_income = $request->get('father_annual_income');
                    $info->mother_phone_number = $request->get('mother_phone_number');
                    $info->mother_national_id =$request->get('mother_national_id');
                    $info->mother_occupation = $request->get('mother_occupation');
                    $info->mother_designation = $request->get('mother_designation');
                    $info->mother_annual_income = $request->get('mother_annual_income');
                    $info->is_sms_enabled = $request->sms_enabled == 'true' ? true : false;
                    $info->user_id = $tb->id;
                    $info->save();
                }
            }
            return back()->with('error', 'Something went wrong please try again!');
        });

        return back()->with('status', $request->name.' User Updated');
    }

    public function deactivateUser($id)
    {
        $user = $this->user->findOrFail($id);
        $user->active = 0;
        $user->save();

        return back()->with('status', $user->name.' has been removed!!');
    }

    public function activateUser($id)
    {
        $user = $this->user->findOrFail($id);
        $user->active = 1;
        $user->save();

        return back()->with('status', $user->name.' has been Activated!!');
    }

    public function rfidCreate($id)
    {
        $user = $this->user->where('student_code', $id)->first();

        return view('rfid.create',  compact('user'));
    }

    public function rfidStore(Request $request, $id)
    {
        $user = $this->user->where('student_code', $id)->first();

        $user->rfid = $request->rfid;

        return redirect()->route('user.show', $id)->with('status', $user->name.' RFID set successfull!');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
    }
}

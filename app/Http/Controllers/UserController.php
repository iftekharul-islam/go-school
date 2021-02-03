<?php

namespace App\Http\Controllers;

use App\Events\NewUserRegistered;
use App\Http\Requests\ImportStudentRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Requests\user\UpdateStaffProfileRequest;
use App\School;
use App\StudentInfo;
use App\User;
use App\Myclass;
use App\Section;
use App\Department;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use App\Exports\ExportStudent;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateAdminRequest;
use App\Http\Requests\User\CreateTeacherRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\CreateLibrarianRequest;
use App\Http\Requests\User\ImpersonateUserRequest;
use App\Http\Requests\User\CreateAccountantRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Shift;
use Carbon\Carbon;

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
    public function index($school_code, $student_code, $teacher_code, Request $request)
    {
        $searchData['section_id']= '';
        $searchData['section_number']= '';
        $searchData['class_id']= '';
        $searchData['class_name']= '';
        $searchData['student_name']= '';

        session()->forget('section-attendance');
        $classes = Myclass::with('sections')->where('school_id', \auth::user()->school_id)->get();

        if ($this->userService->isListOfStudents($school_code, $student_code)) {
            if($request->section_id){
                $searchedSection = Section::with('class')->find($request->section_id);
                $searchData['section_id'] =  $searchedSection->id;
                $searchData['section_number'] =  $searchedSection->section_number;
                $searchData['class_id'] =  $searchedSection->class->id;
                $searchData['class_name'] =  $searchedSection->class->class_number;
            }

            if($request->student_name){
                $searchData['student_name']= $request->student_name;
            }
            $show = $request->show ? $request->show : 20;
            return $this->userService->indexView('list.new-student-list', $this->userService->getStudents($request->section_id, $request->student_name, $show), $classes, $searchData,
             $type = 'Students');
        } elseif ($this->userService->isListOfTeachers($school_code, $teacher_code)) {
            return $this->userService->indexView('list.new-teacher-list',$this->userService->getTeachers(), $classes,'',  $type = 'Teachers');
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
        $classes = Myclass::with('sections')->where('school_id', Auth::user()->id)->get();
        if ($this->userService->isAccountant($role)) {
            return $this->userService->indexOtherView('accounts.new-accountant-list', $this->userService->getAccountants(), $classes, 'accountant');
        } elseif ($this->userService->isLibrarian($role)) {
            return $this->userService->indexOtherView('library.new-librarian-list', $this->userService->getLibrarians(), $classes, 'librarian');
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
    public function storeStudent(CreateUserRequest $request)
    {
        $path = $request->hasFile('student_pic') ? Storage::disk('public')->put('school-' . \Auth::user()->school_id . '/' . date('Y'), $request->file('student_pic')) : null;
        $password = $request->password;
        $tb = $this->userService->storeStudent($request, $path);
        $this->userService->storeStudentInfo($request, $tb);
        if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL))
        {
            event(new UserRegistered($tb, $password));
        }
        return back()->with('status', 'New Student Added!');
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

    public function importStudent()
    {
        $user = Auth::user();

        $studentClasses = Myclass::query()
            ->where('school_id', $user->school->id)
            ->pluck('id');

        $studentSections = Section::with('class')
            ->whereIn('class_id', $studentClasses)
            ->get();

        return view('school.import-student',compact('studentSections','studentClasses','user'));
    }

    public function createStudent()
    {
        $user = Auth::user();
        $studentClasses = Myclass::query()
        ->where('school_id', $user->school->id)
        ->pluck('id');

        $studentSections = Section::with('class')
        ->whereIn('class_id', $studentClasses)
        ->get();

        $guardians = User::Guardian()
        ->where('active', 1)
        ->get();

        if (!$guardians) {

            return redirect()->route('admin.home')->with('error', __('text.guardian_add_notification'));
        }

        $departments = Department::where('school_id', $user->school_id)->get();

        $adminAccessDepartment = Department::where('school_id', $user->school_id)
            ->whereIn('id', Auth::user()->adminDepartments()->pluck('departments.id'))
            ->get();

        return view('school.create-new-student', compact( 'departments','adminAccessDepartment','studentClasses', 'studentSections', 'guardians'));

    }

    public function createTeacher()
    {
        $user = Auth::user();

        $schools = School::all();
        $classes = Myclass::orderby('class_number', 'ASC')->get();
        $sections = Section::orderby('section_number', 'ASC')->get();
        $shifts = Shift::where('school_id', Auth::user()->school_id)->orderby('shift', 'ASC')->get();

        $teacherDepartments = Department::where('school_id', $user->school_id)->orderby('department_name', 'ASC')->get();
        $teacherClasses = Myclass::where('school_id', $user->school->id)->pluck('id');
        $teacherSections = Section::with('class')->whereIn('class_id', $teacherClasses)->get();

        $teachers = User::where('role', 'teacher')
            ->orderBy('name', 'ASC')
            ->where('active', 1)
            ->get();
        $departments = Department::where('school_id', $user->school_id)->get();

        $adminAccessDepartment = Department::where('school_id', $user->school_id)->whereIn('id', Auth::user()->adminDepartments()->pluck('departments.id'))->get();

        return view('school.create-new-teacher', compact('schools', 'classes', 'sections', 'teachers', 'departments', 'adminAccessDepartment', 'teacherClasses', 'teacherDepartments', 'teacherSections', 'shifts'));
    }
    public function createAccountant()
    {
        return view('school.create-new-accountant');
    }
    public function createLibrarian()
    {
        return view('school.create-new-librarian');
    }
    public function createStaff()
    {
        return view('school.create-new-staff');
    }
    public function staffList(Request $request)
    {
        $users = User::with('school')
            ->where('school_id', auth()->user()->school_id)
            ->whereNotIn('role', ['teacher', 'student', 'admin', 'master', 'librarian', 'accountant'])
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->paginate(40);

        return view('list.new-staff-list',compact('users'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeTeacher(CreateTeacherRequest $request)
    {
        $path = $request->hasFile('teacher_pic') ? Storage::disk('public')->put('school-'.Auth::user()->school_id.'/'.date('Y'), $request->file('teacher_pic')) : null;
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'teacher', $path);
        if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) 
        {
            event(new UserRegistered($tb, $password));
        }
        return back()->with('status', 'Teacher Created');
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

        return redirect('admin/users/' .Auth::user()->school->code. '/accountant')->with('status', 'Accountant created');
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

        return redirect('admin/users/' .Auth::user()->school->code. '/librarian')->with('status', 'Librarian Created');
    }

    public function storeStaff(UpdateStaffRequest $request)
    {
        $path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('pic_path')) : null;

        $tb = new $this->user();
        $tb->name = $request->name;
        $tb->email = $request->email;
        $tb->password = 'secret';
        $tb->role = $request->designation;
        $tb->active = 1;
        $tb->about = (!empty($request->about)) ? $request->about : '';
        $tb->address = $request->address;
        $tb->school_id = auth()->user()->school_id;
        $tb->code = auth()->user()->code;
        $tb->student_code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
        $tb->gender = $request->gender;
        $tb->blood_group = $request->blood_group;
        $tb->nationality = (!empty($request->nationality)) ? $request->nationality : 'Bangladeshi';
        $tb->phone_number = $request->phone_number;
        $tb->pic_path = $path ? 'storage/' . $path : '';
        $tb->verified = 1;
        $tb->department_id = (!empty($request->department_id)) ? $request->department_id : 0 ;
        $tb->shift_id = (!empty($request->shift_id)) ? $request->shift_id : null ;
        $tb->save();

        // Store default data on attendance table for a new user
        event(new NewUserRegistered($tb));
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb));
        } catch (\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return redirect()->route('staff.list')->with('status', 'New Staff Created');
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
        $user->load('shift');
        $school = Auth::user();
        $school->load('school');

        return view('profile.user-profile', compact('user', 'school'));
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
        $user->load('shift');
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
        
        $shifts = Shift::where('school_id', Auth::user()->school_id)->get();

        return view('profile.new-edit', [
            'user' => $user,
            'sections' => $sections,
            'departments' => $departments,
            'shifts' => $shifts
        ]);
    }

    /**
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $path = $request->hasFile('pic_path') ? Storage::disk('public')->put('school-' . \Auth::user()->school_id . '/' . date('Y'), $request->file('pic_path')) : null;
        $image_path = 'storage/' . $path;
        DB::transaction(function () use ($request, $image_path) {
            $tb = $this->user->findOrFail($request->user_id);
            $tb->name = $request->name;
            $tb->email = (!empty($request->email)) ? $request->email : $tb->email;
            $tb->nationality = (!empty($request->nationality)) ? $request->nationality : $tb->nationality;
            $tb->section_id = $request->section;
            $tb->phone_number = $request->phone_number;
            $tb->address = (!empty($request->address)) ? $request->address : $tb->address;
            $tb->about = (!empty($request->about)) ? $request->about : $tb->about;
            $tb->pic_path = (empty($request->pic_path)) ? $tb->pic_path : $image_path;
            $tb->blood_group = (!empty($request->blood_group)) ? $request->blood_group : $tb->blood_group;
            $tb->gender = (!empty($request->gender)) ? $request->gender : $tb->gender;
            $tb->department_id = (!empty($request->department_id)) ? $request->department_id : 0;

            if ($request->user_role == 'teacher') {
                $tb->department_id = (!empty($request->department_id)) ? $request->department_id : 0;
                $tb->section_id = $request->class_teacher_section_id;
                $tb->shift_id = $request->shift_id;
            }

            if (!$tb->save()) {
                return back()->with('error', 'Something went wrong please try again!');
            }

            if ($request->user_role != 'student') {

                return back()->with('status', $request->name . ' User Updated');

            }

            if (isset($request->section)) {
                // Update data on attendance table for a student
                event(new NewUserRegistered($tb));
            }

            $info = StudentInfo::firstOrCreate(['user_id' => $tb->id]);
            $info->student_id = $tb->student_code;
            $info->session = $request->get('session');
            $info->version = $request->get('version');
            $info->shift = $request->get('shift');
            $info->student_indentification = $request->get('student_indentification');
            $info->roll_number = $request->get('roll_number');
            $info->group = $request->get('group');
            $info->birthday = $request->get('birthday');
            $info->religion = $request->get('religion');
            $info->guardian_name = $request->get('guardian_name');
            $info->guardian_phone_number = $request->get('guardian_phone_number');
            $info->father_name = $request->get('father_name');
            $info->father_phone_number = $request->get('father_phone_number');
            $info->father_national_id = $request->get('father_national_id');
            $info->father_occupation = $request->get('father_occupation');
            $info->father_designation = $request->get('father_designation');
            $info->father_annual_income = $request->get('father_annual_income');
            $info->mother_phone_number = $request->get('mother_phone_number');
            $info->mother_national_id = $request->get('mother_national_id');
            $info->mother_occupation = $request->get('mother_occupation');
            $info->mother_designation = $request->get('mother_designation');
            $info->mother_annual_income = $request->get('mother_annual_income');
            $info->is_sms_enabled = $request->sms_enabled == 'true' ? true : false;
            $info->user_id = $tb->id;
            $info->save();

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

    public function importStudents(ImportStudentRequest $request)
    {
        Excel::import(new usersImport($request->section), $request->file('users'));
        $msg = 'Student Successfully added';
        if (Session::has('headerwarining') && Session::get('headerwarining') == true)
        {
            $msg = 'Some mandatory Header column is missing, Column: ' .implode(', ', Session::get('error_head') );
            session()->forget('headerwarining');
        }
        if (Session::has('importWarning') && Session::get('importWarning') == true)
        {
            $msg = 'Few rows are skipped due to invalid data.Row number : '.implode(', ', Session::get('error_rows'));
            session()->forget('importWarning');
            session()->forget('error_rows');
        }
        if (Session::has('duplicateWarning') && Session::get('duplicateWarning') == true)
        {
            $msg = 'Duplicated entry skipped';
            session()->forget('duplicateWarning');
        }
        return redirect()->back()->with('status', $msg);
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
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('status', 'Student deleted permanently!');
    }

    public function inactiveAccount() 
    {
        if (Auth::check()) {

            $school = School::find(Auth::user()->school_id);
            if(!empty($school) && $school['is_active'] == 1){
                return redirect(Auth::user()->role.'/home');
            }
        }

        return view('inactive-account');
    }
    
    public function bulkAction(Request $request)
    {
        $message = '';
        if ($request->action == 'enable_sms' || $request->action == 'disable_sms') {
            $status = $request->action == 'enable_sms' ? 1 : 0;
            StudentInfo::whereIn('user_id', $request->user_ids)->update(['is_sms_enabled' => $status]);
            $message = $request->action == 'enable_sms' ? 'Message enabled successfully' : 'Message disabled successfully';
        }
        elseif ($request->action == 'deactivate') {
            User::whereIn('id', $request->user_ids)->update(['active' => 0]);
            $message = 'User(s) deactivated';
        }
        elseif ($request->action == 'activate') {
            User::whereIn('id', $request->user_ids)->update(['active' => 1]);
            $message = 'User(s) activated';
        }
        elseif ($request->action == 'delete') {
            User::whereIn('id', $request->user_ids)->delete();
            $message = 'User(s) deleted';
        }

        return back()->with('status' , $message);
    }

    public function exportStudent(Request $request){
        $keys = $request->get('keys')  ? unserialize($request->get('keys')) : [];
        $fileName = Carbon::now()->format('Y_m_d_g_i_s_a').'_students.xls';
        return Excel::download(new  ExportStudent($keys), $fileName );
    }

    public function uploadStudentPic(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:500',
        ]);
        $user = User::findOrfail($request->user_id);

        if($request->hasFile('image')){
            if(!empty($user->pic_path)){
                Storage::disk('public')->delete($user->pic_path);
            }
            $path =  Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('image'));
            $user->pic_path = 'storage/'.$path;
        }
        $user->save();

        return back()->with('status', 'Student Image Uploaded');
    }

    public function getDownload(){

        //excel file is stored under project/public/download/Import_sample.xlsx
        $file= public_path(). "/download/Import_sample.xlsx";

        if (file_exists($file))
        {
            $headers = array(
                'Content-Type: application/xlsx',
            );
            return Response::download($file, 'Import_sample.xlsx', $headers);
        }
        else
        {
            return redirect()->back()->with('error', 'Requested file does not exist on our server!');
        }
    }
}

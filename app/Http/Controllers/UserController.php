<?php

namespace App\Http\Controllers;

use App\Department;
use App\Myclass;
use App\Section;
use App\StudentInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateAdminRequest;
use App\Http\Requests\User\CreateTeacherRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\ImpersonateUserRequest;
use App\Http\Requests\User\CreateLibrarianRequest;
use App\Http\Requests\User\CreateAccountantRequest;
use Mavinoo\LaravelBatch\Batch;
use App\Events\UserRegistered;
use App\Events\StudentInfoUpdateRequested;
use Illuminate\Support\Facades\Log;
use App\Services\User\UserService;
/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    protected $userService;
    protected $user;

    public function __construct(UserService $userService, User $user){
        $this->userService = $userService;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @param $school_code
     * @param $student_code
     * @param $teacher_code
     * @return \Illuminate\Http\Response
     */
    public function index($school_code, $student_code, $teacher_code){
        session()->forget('section-attendance');
        
        if($this->userService->isListOfStudents($school_code, $student_code))
            return $this->userService->indexView('list.new-student-list', $this->userService->getStudents());
        else if($this->userService->isListOfTeachers($school_code, $teacher_code))
            return $this->userService->indexView('list.new-teacher-list',$this->userService->getTeachers());
        else
            return view('home');
    }

    /**
     * @param $school_code
     * @param $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexOther($school_code, $role){
        if($this->userService->isAccountant($role))
            return $this->userService->indexOtherView('accounts.new-accountant-list', $this->userService->getAccountants());
        else if($this->userService->isLibrarian($role))
            return $this->userService->indexOtherView('library.new-librarian-list', $this->userService->getLibrarians());
        else
            return view('home');
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

        return view('auth.student',[
           'classes' => $classes,
//            'register_sections' => $sections,
            session(['register_role' => 'student', 'register_sections' => $sections,])
            ]);
//        return redirect()->route('register');
    }

    /**
     * @param $section_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sectionStusectionStudents($section_id)
    {
        $students = $this->userService->getSectionStudentsWithSchool($section_id);

        return view('profile.new-section-students', compact('students'));
    }

    /**
     * @param $section_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function promoteSectionStudents($section_id)
    {
        if($this->userService->hasSectionId($section_id))
            return $this->userService->promoteSectionStudentsView(
                $this->userService->getSectionStudentsWithStudentInfo($section_id),
                Myclass::with('sections')->where('school_id', Auth::user()->school_id)->get(),
                $section_id
            );
        else
            return $this->userService->promoteSectionStudentsView([], [], $section_id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function promoteSectionStudentsPost(Request $request)
    {   
        return $this->userService->promoteSectionStudentsPost($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePasswordGet()
    {
        return view('profile.new-change-password');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePasswordPost(ChangePasswordRequest $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {

            return redirect()->back()->with("error-status","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error-status","New Password cannot be same as your current password. Please choose a different password.");
        }
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return redirect()->back()->with("status","Password updated");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function impersonateGet()
    {
        if (app('impersonate')->isImpersonating()) {
            Auth::user()->leaveImpersonation();
            return redirect('/home');
        }
        else {
            return view('profile.impersonate', [
                'other_users' => $this->user->where('id', '!=', auth()->id())->get([ 'id', 'name', 'role' ])
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function impersonate(ImpersonateUserRequest $request)
    {
        $user = $this->user->find($request->id);
        Auth::user()->impersonate($user);
        return redirect('/home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            $password = $request->password;
            $tb = $this->userService->storeStudent($request);
            try {
                // Fire event to store Student information
                if(event(new StudentInfoUpdateRequested($request,$tb->id))){
                    // Fire event to send welcome email
                    event(new UserRegistered($tb, $password));
                } else {
                    throw new \Exeception('Event returned false');
                }
            } catch(\Exception $ex) {
                Log::info('Email failed to send to this address: '.$tb->email.'\n'.$ex->getMessage());
            }

        });
        return back()->with('status', 'Account created');
    }

    /**
     * @param CreateAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function createAdmin()
    {
        return view('auth.admin');
    }

    public function storeAdmin(CreateAdminRequest $request)
    {
        $password = $request->password;
        $tb = $this->userService->storeAdmin($request);
        try {
            // Fire event to send welcome email
            // event(new userRegistered($userObject, $plain_password)); // $plain_password(optional)
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->with('status', 'Admin Created');
    }

    /**
     * @param CreateTeacherRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeTeacher(CreateTeacherRequest $request)
    {
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'teacher');
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->with('status', 'Saved');
    }

    /**
     * @param CreateAccountantRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAccountant(CreateAccountantRequest $request)
    {
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'accountant');
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->with('status', 'Saved');
    }

    /**
     * @param CreateLibrarianRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLibrarian(CreateLibrarianRequest $request)
    {
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'librarian');
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

        return back()->with('status', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return UserResource
     */
    public function show($user_code)
    {
        $user = $this->userService->getUserByUserCode($user_code);
        return view('profile.user-profile', compact('user'));
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
        $user = $this->user->find($id);
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
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            $tb = $this->user->find($request->user_id);
            $tb->name = $request->name;
            $tb->email = (!empty($request->email)) ? $request->email : '';
            $tb->nationality = (!empty($request->nationality)) ? $request->nationality : '';
            $tb->phone_number = $request->phone_number;
            $tb->address = (!empty($request->address)) ? $request->address : '';
            $tb->about = (!empty($request->about)) ? $request->about : '';
            $tb->pic_path = (!empty($request->pic_path)) ? $request->pic_path : '';
            if ($request->user_role == 'teacher') {
                $tb->department_id = $request->department_id;
                $tb->section_id = $request->class_teacher_section_id;
            }
            if ($tb->save()) {
                if ($request->user_role == 'student') {
                    try{
                        event(new StudentInfoUpdateRequested($request,$tb->id));
                    } catch(\Exception $ex) {
                        Log::info('Failed to update Student information, Id: '.$tb->id. 'err:'.$ex->getMessage());
                    }
                }
            }
        });

        return back()->with('status', $request->name. ' User Updated');
    }

    /**
     * Activate admin
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateAdmin($id)
    {
        $admin = $this->user->find($id);

        if ($admin->active !== 0) {
            $admin->active = 0;
        } else {
            $admin->active = 1;
        }

        $admin->save();

        return back()->with('status', $admin->name.' active status changed');
    }

    /**
     * Deactivate admin
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivateAdmin($id)
    {
       $admin = $this->user->find($id);
       $admin->active = !$admin->active;

       $admin->save();

        return back()->with('status', 'Saved');
    }
    public function deactivateUser($id)
    {
       $user = $this->user->find($id);
       $user->active = 0;
//       return $user;
       $user->save();

        return back()->with('status', $user->name .' has been removed!!');
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
        // return ($this->user->destroy($id))?response()->json([
      //   'status' => 'success'
      // ]):response()->json([
      //   'status' => 'error'
      // ]);
    }
}

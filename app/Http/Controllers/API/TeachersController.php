<?php

namespace App\Http\Controllers\API;

use App\Events\UserRegistered;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\User\UserService;
use App\Http\Requests\User\CreateTeacherRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TeachersController extends Controller
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
     * @param $school_code  ( admin school code )
     * @return \Illuminate\Http\Response
     * @return error false
     * @return Teachers List
     */
    public function index($school_code)
    {
        $teachers = $this->userService->getTeachers();

        return response([
            'error' => false,
            'teachers' => $teachers,
        ]);
    }


    /**
     * @param CreateTeacherRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTeacherRequest $request)
    {
        $path =  $request->hasFile('teacher_pic') ? Storage::disk('public')->put('school-'.Auth::user()->school_id.'/'.date("Y"), $request->file('teacher_pic')) : null;
        $password = $request->password;
        $tb = $this->userService->storeStaff($request, 'teacher', $path);
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email failed to send to this address: '.$tb->email);
        }

//        return back()->withInput(['tab'=> 'tab13'] )->with('status', 'Teacher Created');
        return response([
            'error' => false,
            'massage' => 'New Teacher Created'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user_code ( School Code )
     * @return \Illuminate\Http\Response
     * @return $user
     */
    public function show($user_code)
    {
        //
        $user = $this->userService->getUserByUserCode($user_code);

        return response([
            'error' => false,
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

        DB::transaction(function () use ($request) {
            $tb = $this->user->findOrFail($request->user_id);
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
            $tb->save();
        });

//        return back()->with('status', $request->name. ' User Updated');
        return response([
            'error' => false,
            'Massage' => 'Successfully update'
        ]);
    }

    /**
     * @param $id (Teacher Id)
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @return $user->name
     */

    public function deactivateUser($id)
    {
        $user = $this->user->findOrFail($id);
        $user->active = 0;
        $user->save();
//        return back()->with('status', $user->name .' has been removed!!');
        return response([
            'error' => false,
            'Massage' => $user->name . ' has been remove'
        ]);
    }

    /**
     * @param $id (Teacher Id)
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @return $user->name
     */

    public function activateUser($id)
    {
        $user = $this->user->findOrFail($id);
        $user->active = 1;
        $user->save();
//        return back()->with('status', $user->name .' has been Activated!!');
        return response([
            'error' => true,
            'Massage' => $user->name . ' has been Activated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

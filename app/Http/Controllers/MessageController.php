<?php

namespace App\Http\Controllers;

use App\Message as Message;
use App\Http\Resources\MessageResource;
use App\Myclass;
use App\Services\User\UserService;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\FeeTransaction;

class MessageController extends Controller
{

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($school_id)
    {
        return ($school_id > 0)? MessageResource::collection(Message::where('school_id', $school_id)->get()):response()->json([
            'Invalid School id: '. $school_id,
            404
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tb = new Message;
        $tb->phone_number = $request->phone_number;
        $tb->email = $request->email;
        $tb->message = $request->message;
        $tb->school_id = $request->school_id;

        return($tb->save())?response()->json([
            'status' => 'success'
        ]):response()->json([
            'status' => 'error'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new MessageResource(Message::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tb = Message::find($id);
        $tb->phone_number = $request->phone_number;
        $tb->email = $request->email;
        $tb->message = $request->message;
        $tb->school_id = $request->school_id;
        return ($tb->save())?response()->json([
            'status' => 'success'
        ]):response()->json([
            'status' => 'error'
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
        return (Message::destroy($id))?response()->json([
            'status' => 'success'
        ]):response()->json([
            'status' => 'error'
        ]);
    }
    public function adminSendMessage(Request $request)
    {

        $classes = Myclass::with('sections')->where('school_id', Auth::user()->school_id)->get();
        $students = $this->userService->getSectionStudentsWithSchool($request->section);
        return view('message.message-student', compact('students','classes'));
    }
}

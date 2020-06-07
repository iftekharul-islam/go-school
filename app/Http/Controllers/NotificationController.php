<?php

namespace App\Http\Controllers;

use App\Jobs\SendSmsToStudents;
use App\Notification as Notification;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $msg = Notification::with('teacher.department')->where('student_id',$id)->orderBy('created_at','desc')->paginate(10);
        foreach($msg as $m){
            if ($m->active == 1)
            {
                $message = Notification::findOrFail($m->id);
                $message->active = 0;
                $message->updated_at = now();
                $message->save();
            }

        }
        return view('message.all-message',['messages'=>$msg]);
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
     *  a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
            'recipients' => 'required|array',
            'msg' => 'required|string',
        ]);
        DB::transaction(function ( ) use ($request) {
            $n = [];
            for($i=0; $i < count($request->recipients); $i++){
                $path = $request->hasFile('file_path') ? Storage::disk('public')->put('school-'.\Auth::user()->school_id.'/'.date('Y'), $request->file('file_path')) : null;
                $tb = new Notification;
                $tb->sent_status = 1;
                $tb->active = 1;
                $tb->message = $request->msg;
                $tb->student_id = $request->recipients[$i];
                $tb->user_id = $request->teacher_id;
                $tb->file_path = $path ? 'storage/' . $path : '';
                $tb->sms_count = $request->sms_count;
                $tb->created_at = date('Y-m-d H:i:s');
                $tb->updated_at = date('Y-m-d H:i:s');
                $n[] = $tb->attributesToArray();
            }
            Notification::insert($n);
        });
        $school = Auth::user()->school;

        if (isset($request->sent_sms) && $school->is_sms_enable == 1 )
        {
            foreach ($request->recipients as $student_id)
            {
                SendSmsToStudents::dispatch($student_id, $request->msg);
            }
        }
        return back()->with('status','Message Sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new NotificationResource(Notification::find($id));
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
        $tb = Notification::find($id);
        $tb->student_id = $request->student_id;
        $tb->message = $request->message;
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
        $message = Notification::findOrFail($id);
        $message->delete();

        return back()->with('status', 'Message deleted permanently!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\NoticeRequest;
use App\Notice;
use App\Http\Resources\NoticeResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school_id = Auth::user()->school->id;
        $minutes = 1440;
        $notices = Cache::remember('notices-' . $school_id, $minutes, function () use ($school_id) {
            return Notice::where('school_id', $school_id)
                ->where('active', 1)
                ->orderBy('created_at', 'DESC')
                ->get();
        });
        $events = Cache::remember('events-' . $school_id, $minutes, function () use ($school_id) {
            return Event::where('school_id', $school_id)
                ->where('active', 1)
                ->orderBy('created_at', 'DESC')
                ->get();
        });
        return view('notices.index', compact('notices', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $files = Notice::where('school_id',Auth::user()->school_id)->where('active',1)->orderBy('created_at', 'DESC')->get();
        return view('notices.list',['files'=>$files]);
    }
    public function create()
    {
        return view('notices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticeRequest $request)
    {
        $user = Auth::user();
        $path = $request->hasFile('file_path') ? Storage::disk('public')->put('school-' . $user->school_id . '/' . date('Y'), $request->file('file_path')) : null;

        $tb = new Notice;
        $tb->file_path = $path ? 'storage/' . $path : '';
        $tb->title = $request->title;
        $tb->description = $request->description;
        $tb->active = 1;
        $tb->school_id = $user->school_id;
        $tb->user_id = $user->id;
        $tb->save();
        return back()->with('status', 'New notice upload complete');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = Auth::user();
        $notices = Notice::where('school_id', $users->school_id)
                ->where('active', 1)
                ->get();

        $notice ='';
        foreach ($notices as $ntc)
        {
            if ($ntc['id'] == $id )
            {
                $notice = $ntc;
            }
        }

        return view('notices.show',compact('notices','notice'));

//        return new NoticeResource(Notice::findOrFail($id));
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
    public function update($id)
    {
        $tb = Notice::findOrFail($id);
        $tb->active == 1 ? $tb->active = 0 : $tb->active = 1;
        $tb->save();
        return back()->with('status','Notice Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (Notice::destroy($id))?response()->json([
            'status' => 'success'
        ]):response()->json([
            'status' => 'error'
        ]);
    }


}

<?php

namespace App\Http\Controllers;

use App\Event;
use App\Notice;
use App\Http\Resources\NoticeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
    public function create()
    {
        $files = Notice::where('school_id',Auth::user()->school_id)->where('active',1)->orderBy('created_at', 'DESC')->get();
        return view('notices.create',['files'=>$files]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string|max:255',
            'title' => 'required|string|max:255',
        ]);
        $user = Auth::user();
        $tb = new Notice;
        $tb->file_path = $request->file_path;
        $tb->title = $request->title;
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
        return new NoticeResource(Notice::findOrFail($id));
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

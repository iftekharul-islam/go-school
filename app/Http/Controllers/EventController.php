<?php

namespace App\Http\Controllers;

use App\Event as Event;
use App\Http\Requests\CreateEventRequest;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class_id)
    {
        return ($class_id > 0)? EventResource::collection(Event::where('class_id', $class_id)->get()):response()->json(['Invalid Class id: '. $class_id, 404]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function eventList()
    {
        $files = Event::where('school_id', Auth::user()
            ->school_id)->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('events.index', ['files' => $files]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *x
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEventRequest $request)
    {
        $user = Auth::user();
        $path = $request->hasFile('file_path') ? Storage::disk('public')->put('school-' . $user->school_id . '/' . date('Y'), $request->file('file_path')) : null;

        $tb = new Event;
        $tb->file_path = $path ? 'storage/' . $path : '';
        $tb->title = $request->title;
        $tb->description = $request->description;
        $tb->active = 1;
        $tb->school_id = $user->school_id;
        $tb->user_id = $user->id;
        $tb->roles = isset($request->roles) ? serialize($request->roles) : null;
        $tb->save();

        return redirect()->route('academic.event')->with('status', __('text.notice_upload_notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EventResource(Event::find($id));
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
        $tb = Event::findOrFail($id);
        $tb->active == 0 ? $tb->active = 1 : $tb->active = 0;
        $tb->save();
        $status = $tb->active == 0 ? $status = 'inactive' : $status = 'active';
        return back()->with('status','Event status changed to '.$status.'!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (Event::destroy($id))?response()->json([
            'status' => 'success'
        ]):response()->json([
            'status' => 'error'
        ]);
    }
}

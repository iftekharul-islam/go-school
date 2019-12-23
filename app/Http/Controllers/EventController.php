<?php

namespace App\Http\Controllers;

use App\Event as Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $files = Event::where('school_id',Auth::user()->school_id)->where('active',1)->orderBy('created_at','DESC')->get();
        return view('events.create',['files'=>$files]);
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
        $tb = new Event;
        $tb->file_path = $request->file_path;
        $tb->title = $request->title;
        $tb->active = 1;
        $tb->school_id = Auth::user()->school_id;
        $tb->user_id = Auth::user()->id;
        $tb->save();
        return back()->with('status', 'Uploaded');
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

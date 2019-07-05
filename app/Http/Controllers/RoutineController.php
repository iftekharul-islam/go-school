<?php

namespace App\Http\Controllers;

use App\Routine as Routine;
use App\Http\Resources\RoutineResource;
use App\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
       $files = Routine::with('section')
                        ->where('school_id',\Auth::user()->school_id)
                        ->orderBy('created_at', 'DESC')
                        ->get();
        return view('routines.index',['files'=>$files,'section_id' => 1]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $section_id)
    {
//      return Syllabus::all();
      try{
        if(Schema::hasColumn('routines','section_id')){
          $files = Routine::with('section')
                          ->where('school_id',\Auth::user()->school_id)
                          ->where('section_id', $section_id)
                          ->where('active',1)
                          ->get();
        } else {
          return '<code>section_id</code> column missing. Run <code>php artisan migrate</code>';
        }
      } catch(Exception $ex){
        return 'Something went wrong!!';
      }
//      return $files;
      return view('routines.new-create',['files'=>$files,'section_id'=>$section_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      return $request;
      $request->validate([
        'file_path' => 'required|string|max:255',
        'title' => 'required|string|max:255',
      ]);
      $tb = new Routine;
      $tb->file_path = $request->file_path;
      $tb->title = $request->title;
      $tb->active = 1;
      $tb->school_id = \Auth::user()->school_id;
      $tb->user_id = \Auth::user()->id;
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
        return new RoutineResource(Routine::find($id));
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
      $tb = Routine::find($id);
      $tb->active == 1 ? $tb->active = 0 : $tb->active = 1;
      $tb->save();
      return back()->with('status','Routine status changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      return (Routine::destroy($id))?response()->json([
        'status' => 'success'
      ]):response()->json([
        'status' => 'error'
      ]);
    }
}

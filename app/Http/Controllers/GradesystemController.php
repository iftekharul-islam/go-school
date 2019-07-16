<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeSystemRequest;
use Illuminate\Http\Request;
use App\Gradesystem as Gradesystem;

class GradesystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $gpas = Gradesystem::where('school_id', \Auth::user()->school_id)->get();
        return view('gpa.all',['gpas'=>$gpas]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('gpa.new-create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradeSystemRequest $request){

        $gpa = new Gradesystem;
        $gpa->grade_system_name = $request->grade_system_name;
        $gpa->point = $request->point;
        $gpa->grade = $request->grade;
        $gpa->from_mark = $request->from_mark;
        $gpa->to_mark = $request->to_mark;
        $gpa->school_id = \Auth::user()->school_id;
        $gpa->user_id = \Auth::user()->id;
        $gpa->save();
        return back()->with('status', 'Saved');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $grade = Gradesystem::findOrFail($id);
        return view('gpa.edit', compact('grade'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $gpa = Gradesystem::findOrFail($id);
        $gpa->grade_system_name = $request->grade_system_name;
        $gpa->point = $request->point;
        $gpa->grade = $request->grade;
        $gpa->from_mark = $request->from_mark;
        $gpa->to_mark = $request->to_mark;
        $gpa->school_id = \Auth::user()->school_id;
        $gpa->user_id = \Auth::user()->id;
        $gpa->save();
        return redirect()->back()->with('status', 'Grade System Updated !!');
    }
      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
    public function destroy($id){
      $gpa = Gradesystem::findOrFail($id);
      $gpa->delete();
      return back()->with('status', 'Deleted!');
    }
}

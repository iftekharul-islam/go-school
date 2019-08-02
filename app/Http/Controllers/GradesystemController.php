<?php

namespace App\Http\Controllers;

use App\GradeSystemInfo;
use App\Http\Requests\GradeInfoRequest;
use App\Http\Requests\GradeSystemRequest;
use Illuminate\Http\Request;
use App\Gradesystem as Gradesystem;
use Illuminate\Support\Facades\Auth;

class GradesystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $gpa = Gradesystem::with('gradeSystemInfo')->where('school_id', \Auth::user()->school_id)->first();

        return view('gpa.all',compact('gpa'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $grade_systems = Gradesystem::where('school_id', Auth::user()->school_id)->firstOrFail();
        return view('gpa.new-create', compact('grade_systems'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradeSystemRequest $request){
        $data = [
            'grade_system_name' => $request->get('grade_system_name'),
            'school_id' => Auth::user()->school_id
        ];
        Gradesystem::create($data);
        return back()->with('status', 'New Grade System Added');
    }

    public function storeGradeInfo(GradeInfoRequest $request)
    {
        $data = [
            'grade' => $request->get('grade'),
            'grade_points' => $request->get('point'),
            'marks_from' => $request->get('from_mark'),
            'marks_to' => $request->get('to_mark'),
            'gradesystem_id' => $request->get('grade_system_id'),
        ];
        GradeSystemInfo::create($data);
        return back()->with('status', 'New Grade Point Added');
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
        $grade = GradeSystemInfo::findOrFail($id);
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
        $gpa = GradeSystemInfo::findOrFail($id);
        $gpa->grade_points = $request->point;
        $gpa->grade = $request->grade;
        $gpa->marks_from = $request->from_mark;
        $gpa->marks_to = $request->to_mark;
        $gpa->save();
        return redirect()->back()->with('status', 'Grade Point info Updated !!');
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
        return back()->with('status', 'Grade System Deleted!');
    }
    public  function  delete($id)
    {
        $gpainfo = GradeSystemInfo::findOrFail($id);
        $gpainfo->delete();
        return redirect()->back()->with('status', 'Grade Information Data Deleted');
    }
}

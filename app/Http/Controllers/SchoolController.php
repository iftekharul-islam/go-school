<?php

namespace App\Http\Controllers;

use App\Gradesystem;
use App\School;
use App\Myclass;
use App\Section;
use App\User;
use App\Department;
//use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::all();
        $classes = Myclass::all();
        $sections = Section::all();

        $studentClasses = Myclass::query()
            ->where('school_id', Auth::user()->school->id)
            ->pluck('id');

        $studentSections = Section::with('class')
            ->whereIn('class_id', $studentClasses)
            ->get();

        $teacherDepartments = Department::where('school_id',\Auth::user()->school_id)->get();
        $teacherClasses = Myclass::where('school_id',\Auth::user()->school->id)->pluck('id');
        $teacherSections = Section::with('class')->whereIn('class_id',$teacherClasses)->get();
        $gradeSystems = Gradesystem::where('school_id', Auth::user()->school_id)->get();

        $teachers = User::where('role', 'teacher')
            ->orderBy('name','ASC')
            ->where('active', 1)
            ->get();
        $departments = Department::where('school_id',\Auth::user()->school_id)->get();
        return view('school.new-create-school', compact('schools',  'gradeSystems','classes', 'sections', 'teachers', 'departments', 'studentClasses', 'studentSections', 'teacherClasses', 'teacherDepartments', 'teacherSections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('school.new-school');
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
            'school_name' => 'required|string|max:255',
            'school_medium' => 'required',
            'school_about' => 'required',
            'school_established' => 'required',
        ]);
        $tb = new School;
        $tb->name = $request->school_name;
        $tb->established = $request->school_established;
        $tb->about = $request->school_about;
        $tb->medium = $request->school_medium;
        $tb->code = date("y").substr(number_format(time() * mt_rand(),0,'',''),0,6);
        $tb->theme = 'flatly';
        $tb->save();
        return redirect('/home')->with('status', 'Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($school_id)
    {
        $admins = User::where('school_id',$school_id)->where('role','admin')->get();
        return view('school.admin-list',compact('admins'));
    }

    public function showSchool($school_id) {
        $admins = User::where('school_id',$school_id)->where('role','admin')->get();
        $total_students = \App\User::where('school_id',$school_id)->where('role','student')->where('active', 1)->count();
        $total_classes =  \App\Myclass::where('school_id', $school_id)->count();
        $total_teacher = \App\User::where('school_id', $school_id)->where('role', 'teacher')->where('active', 1)->count();
        $total_exams = \App\Exam::where('school_id', $school_id)->where('active', 1)->count();
        $school = School::where('id',$school_id)->first();

        return view('school.new-school-master',[
            'school' => $school,
            'total_students' => $total_students,
            'total_classes' => $total_classes,
            'total_teacher' => $total_teacher,
            'total_exams' => $total_exams,
            'admins'     => $admins
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = School::find($id);
        return view('school.new-edit-school', compact('school'));
    }

    public function addDepartment(Request $request){
        $request->validate([
            'department_name' => 'required|string|max:50',
        ]);
        $s = new Department;
        $s->school_id = \Auth::user()->school_id;
        $s->department_name = $request->department_name;
        $s->save();
        return back()->withInput(['tab'=> 'tab8'] )->with('status', 'saved');
    }

    public function allDepartment()
    {
        $dpts = Department::where('school_id', \Auth::user()->school_id)->get();
        return view('school.departments', compact('dpts'));
    }

    public function changeTheme(Request $request){
        $tb = School::find($request->s);
        $tb->theme = $request->school_theme;
        $tb->save();
        return back();
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
        $validatedData = $request->validate([
            'school_name' => 'required',
            'school_medium' => 'required',
            'school_about' => 'required',
        ]);
        $tb = School::find($id);
        $tb->name = $request->school_name;
        $tb->about = $request->school_about;
        $tb->medium = $request->school_medium;
        $tb->save();
        return redirect()->back()->with('status','School Information Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::find($id);
        $school->delete();
        return redirect('/home')->with('status', 'School deleted');
    }
}

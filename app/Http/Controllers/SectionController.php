<?php

namespace App\Http\Controllers;

use App\Course;
use App\Section as Section;
use App\Http\Resources\SectionResource;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\User;
use App\Routine;
use App\Myclass;
use App\ExamForClass;
use Illuminate\Support\Facades\Auth;


class SectionController extends Controller
{

    protected $userService;
    protected $user;

    public function __construct(UserService $userService, User $user){
        $this->userService = $userService;
        $this->user = $user;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $classes = Myclass::where('school_id', $user->school->id)
            ->get();
        $classeIds = Myclass::where('school_id', $user->school->id)
            ->pluck('id')
            ->toArray();

        $exams = ExamForClass::whereIn('class_id',$classeIds)
            ->where('active', 1)
            ->get()->groupBy('class_id');
        return view('school.new-sections',[
            'classes'=>$classes,
            'exams'=>$exams
        ]);
    }

    public function attendanceList(){
        $user = Auth::user();
        $classes = Myclass::where('school_id',$user->school->id)
            ->get();
        $classeIds = Myclass::where('school_id',$user->school->id)
            ->pluck('id')
            ->toArray();
        $sections = Section::whereIn('class_id',$classeIds)
            ->orderBy('section_number')
            ->get();
        $exams = ExamForClass::whereIn('class_id',$classeIds)
            ->where('active', 1)
            ->get()->groupBy('class_id');
        return view('school.attendance',[
            'classes'=>$classes,
            'sections'=>$sections,
            'exams'=>$exams
        ]);
    }

    public function details($class_id)
    {

        $user = Auth::user();
        $classes = Myclass::where('school_id', $user->school->id)
            ->get();
        $classeIds = Myclass::where('school_id', $user->school->id)
            ->pluck('id')
            ->toArray();
        $sections = Section::whereIn('class_id',$classeIds)
            ->orderBy('section_number')
            ->get();
        $exams = ExamForClass::whereIn('class_id',$classeIds)
            ->where('active', 1)
            ->get()->groupBy('class_id');

        return view('school.class-details',[
            'classes'=>$classes,
            'sections'=>$sections,
            'exams'=>$exams,
            'class_id' => $class_id
        ]);
    }

    public function sectionDetails($section_id)
    {

        $courses = Course::where('section_id', $section_id)->get();
        $students = $this->userService->getSectionStudentsWithSchool($section_id);
        $files = Routine::with('section')
            ->where('school_id',Auth::user()->school_id)
            ->where('section_id', $section_id)
            ->where('active',1)
            ->get();

        return view('section.details', compact('courses','students', 'files', 'section_id'));
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
        $request->validate([
            'section_number' => 'required',
            'room_number' => 'required|numeric',
            'class_id' => 'required|numeric',
        ]);
        $tb = new Section;
        $tb->section_number = $request->section_number;
        $tb->room_number = $request->room_number;
        $tb->class_id = $request->class_id;
        $tb->save();
        return back()->withInput(['tab'=> 'tab8'] )->with('status', 'New Section Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new SectionResource(Section::find($id));
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
        $tb = Section::findOrFail($id);
        $tb->section_number = $request->section_number;
        $tb->room_number = $request->room_number;
        $tb->class_id = $request->class_id;
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
        return (Section::destroy($id))?response()->json([
            'status' => 'success'
        ]):response()->json([
            'status' => 'error'
        ]);
    }
}

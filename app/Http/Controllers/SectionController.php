<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\SectionsRequest;
use App\Section;
use App\User;
use App\Course;
use App\Myclass;
use App\Routine;
use App\ExamForClass;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SectionResource;



class SectionController extends Controller
{
    protected $userService;
    protected $user;

    public function __construct(UserService $userService, User $user)
    {
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
        $classes = Myclass::where('school_id', $user->school_id)->orderby('class_number', 'ASC')->get();
        $classFilterByDepartments = Myclass::where('school_id', $user->school_id)
            ->whereIn('department_id', Auth::user()->adminDepartments()->pluck('departments.id'))
            ->get();
        return view('school.new-sections', compact('classes', 'classFilterByDepartments'));
    }

    public function attendanceList()
    {
        $user = Auth::user();
        $classes = Myclass::where('school_id', $user->school_id)
            ->get();
        $classeIds = Myclass::where('school_id', $user->school_id)
            ->pluck('id')
            ->toArray();
        $sections = Section::whereIn('class_id', $classeIds)
            ->orderBy('section_number')
            ->get();
        $exams = ExamForClass::whereIn('class_id', $classeIds)
            ->where('active', 1)
            ->get()->groupBy('class_id');

        return view('school.attendance', compact('classes', 'sections', 'exams'));
    }

    public function details($class_id)
    {
        $user = Auth::user();
        $classes = Myclass::where('school_id', $user->school_id)
            ->get();
        $classeIds = Myclass::where('school_id', $user->school_id)
            ->pluck('id')
            ->toArray();
        $sections = Section::whereIn('class_id', $classeIds)
            ->orderBy('section_number')
            ->get();
        $exams = ExamForClass::whereIn('class_id', $classeIds)
            ->where('active', 1)
            ->get()->groupBy('class_id');

        return view('school.class-details', [
            'classes' => $classes,
            'sections' => $sections,
            'exams' => $exams,
            'class_id' => $class_id,
        ]);
    }

    public function sectionDetails($section_id)
    {
        $courses = Course::where('section_id', $section_id)->get();
        $students = $this->userService->getSectionStudentsWithSchool($section_id);
        $files = Routine::with('section')
            ->where('school_id', Auth::user()->school_id)
            ->where('section_id', $section_id)
            ->where('active', 1)
            ->get();

        return view('section.details', compact('courses', 'students', 'files', 'section_id'));
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
    public function store(SectionsRequest $request)
    {
        $tb = new Section();
        $tb->section_number = $request->section_number;
        $tb->room_number = $request->room_number;
        $tb->class_id = $request->class_id;
        $tb->save();

        return back()->withInput(['tab' => 'tab2', 'tabMain' => 'tab8'])->with('status', 'New Section Created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new SectionResource(Section::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tb = Section::findOrFail($id);
        $tb->section_number = $request->section_number;
        $tb->room_number = $request->room_number;
        $tb->class_id = $request->class_id;

        return ($tb->save()) ? response()->json([
            'status' => 'success',
        ]) : response()->json([
            'status' => 'error',
        ]);
    }

    /**
     * Update Section .
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSection(Request $request, $id)
    {
        $tb = Section::findOrFail($id);
        $tb->section_number = $request->section_number;
        $tb->save();

        return back()->with('status', 'Section updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return back()->with('status', 'Section successfully  deleted');
    }
}

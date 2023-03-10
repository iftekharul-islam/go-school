<?php

namespace App\Http\Controllers;

use App\Course;
use App\Gradesystem;
use App\Http\Resources\CourseResource;
use App\School;
use App\Section;
use App\Services\User\UserService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Course\SaveConfigurationRequest;
use App\Http\Traits\GradeTrait;
use App\Services\Course\CourseService;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use GradeTrait;
    protected $courseService;

    public function __construct(CourseService $courseService, UserService $userService, User $user){
        $this->courseService = $courseService;
        $this->userService = $userService;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($teacher_id, $section_id){
        if($this->courseService->isCourseOfTeacher($teacher_id)) {
            $courses = $this->courseService->getCoursesByTeacher($teacher_id);
            $exams = $this->courseService->getExamsBySchoolId();
            $view = 'course.new-teacher-course';

        } else if($this->courseService->isCourseOfStudentOfASection($section_id)) {
            $courses = $this->courseService->getCoursesBySection($section_id);
            $view = 'course.student-class-course';
            $exams = [];

        } else if($this->courseService->isCourseOfASection($section_id)) {
            $courses = $this->courseService->getCoursesBySection($section_id);
            $exams = $this->courseService->getExamsBySchoolId();
            $view = 'course.student-class-course';
        } else {
            return redirect('home');
        }
        return view($view,compact('courses','exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course.create-course');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function course($teacher_id,$course_id,$exam_id,$section_id)
    {
        $this->addStudentsToCourse($teacher_id,$course_id,$exam_id,$section_id);
        $students = $this->userService->getSectionStudentsWithSchool($section_id);
        return view('course.students', compact('students','teacher_id','section_id'));
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
            'course_name' => 'required|max:255',
            'teacher_id' => 'required',
            'course_type' => 'required',
        ]);
        $grade_system = Gradesystem::where('school_id', Auth::user()->school_id)->first();
        try{
            $this->courseService->addCourse($request, $grade_system);
        } catch (\Exception $ex){
            return back()->withInput(['tab'=> 'tab8'] )->with('error', 'Unable to create Course. Define grade system first from Manage GPA menu');
        }
        return back()->withInput(['tab'=> 'tab8'] )->with('status', 'New Course Created');
    }

    /**
     * @param SaveConfigurationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveConfiguration(SaveConfigurationRequest $request){
       $totalPercentage =
           $request->attendance_percent +
           $request->quiz_percent +
           $request->assignment_percent +
           $request->ct_percent +
           $request->final_exam_percent +
           $request->practical_percent ;

        if ($totalPercentage != 100) {
            return back()->with('error', 'Total percentage should be equal to 100%');
        }

       $totalMarks =
           $request->att_fullmark +
           $request->quiz_fullmark +
           $request->a_fullmark +
           $request->ct_fullmark +
           $request->final_fullmark +
           $request->practical_fullmark;

        if ($totalMarks != 100) {
            return back()->with('error', 'Final marks should be equal to 100%');
        }

        $data = $this->courseService->saveConfiguration($request);
        if ($data) {
            return back()->with('status', 'Configuration Saved');
        }
        return back()->with('error', 'Unable to update Configuration');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CourseResource(Course::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::with('teacher')->findOrFail($id);

        $teachers = User::where('role', 'teacher')
            ->orderBy('name', 'ASC')
            ->where('active', 1)
            ->get();
        return view('course.edit', ['course'=>$course, 'teachers'=>$teachers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateNameAndTime(Request $request, $id)
    {
        $request->validate([
            'course_name' => 'required|string',
            'teacher_id' => 'required|string',
            'course_time' => 'nullable|string',
        ]);
        $this->courseService->updateCourseInfo($id, $request);
        return back()->with('status', 'Course updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (Course::destroy($id))?response()->json([
            'status' => 'success'
        ]):response()->json([
            'status' => 'error'
        ]);
    }
}

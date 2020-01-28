<?php

namespace App\Http\Controllers;

use App\Course;
use App\Exam;
use App\ExamForClass;
use App\Http\Requests\UpdateExamDetailsRequest;
use Illuminate\Http\Request;
use App\Services\Exam\ExamService;
use App\Http\Requests\Exam\CreateExamRequest;
use App\Http\Requests\Exam\UploadExamResultRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService){
        $this->examService = $examService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = $this->examService->getLatestExamsBySchoolIdWithPagination();
        return view('exams.all',compact('exams'));
    }

    public function indexActive(){
        $exams = $this->examService->getActiveExamsBySchoolId();
        $this->examService->examIds = $exams->pluck('id')->toArray();
        $courses = $this->examService->getCoursesByExamIds();
        return view('exams.active',compact('exams','courses'));
    }

    public function details($exam_id) {
        $exams = $this->examService->getActiveExamsBySchoolId();
        $this->examService->examIds = $exams->pluck('id')->toArray();
        $courses = $this->examService->getCoursesByExamIds();
        return view('exams.details',compact('exam_id','courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = $this->examService->getClassesBySchoolId();
        $already_assigned_classes = $this->examService->getAlreadyAssignedClasses();
        $exams = $this->examService->getLatestExamsBySchoolIdWithPagination();
        return view('exams.add',compact('classes','already_assigned_classes', 'exams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExamRequest $request)
    {
        $this->examService->request = $request;
        try{
            $this->examService->storeExam();
        } catch (\Exception $e){
            return 'Error: '. $e->getMessage();
        }
        
        //return $this->cindex($course_id, $exam_id, $teacher_id);
        return back()->with('status', 'New Exam Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        $classes = $this->examService->getClassesBySchoolId();
        $already_assigned_classes = $this->examService->getAlreadyAssignedClasses();
        $exams = $this->examService->getLatestExamsBySchoolIdWithPagination();
        return view('exams.edit',compact('classes','already_assigned_classes', 'exams', 'exam'));
    }

    public function updateExam(UpdateExamDetailsRequest $request, $id) {
        $exam = Exam::findOrFail($id);
        $exam->term = !empty($request->get('other_term')) ? $request->get('other_term') : $request->get('term');
        $exam->exam_name = $request->get('exam_name');
        $exam->start_date = $request->get('start_date');
        $exam->end_date = $request->get('end_date');
        $exam->save();
        return redirect()->back()->with('status', 'Exam record updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|numeric',
        ]);
        try{
            $this->examService->request = $request;
            $this->examService->updateExam();
        } catch (\Exception $e){
            return 'Error: '. $e->getMessage();
        }
        return back()->with('status', 'Exam record updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        $examForClass = ExamForClass::where('exam_id', $id)->get();
        $courses = Course::where('exam_id', $id)->get();
        foreach ($courses as $course) {
            $course->exam_id = 0;
            $course->save();
        }
        foreach ($examForClass as $class) {
            $class->delete();
        }
        return redirect()->back()->with('status', 'Exam Deleted');
    }

    /**update exam result file*/
    public function updateResultFile(UploadExamResultRequest $request, $exam_id) {
        $exam = Exam::findOrFail($exam_id);

        if (!empty($exam->result_file)) {
            Storage::disk('public')->delete($exam->result_file);
        }

        $date = Carbon::now();
        $fileName = Auth::user()->school_id.'_'.$date->format('Y_m_d').'_'.$date->format('g_i_a');
        $path = Storage::disk('public')->put('result', $request->file('result_file'));
        $exam->result_file = $path;
        $exam->save();

        return back()->with('status', 'Result file uploaded');
    }

    /**edit exam result file*/
    public function editResultFile($exam_id) {
        $exam = Exam::findOrFail($exam_id);
        return view('exams.result.upload-result', compact('exam'));
    }

    /**upload exam result file*/
    public function resultFiles() {
        $exams = $exams = $this->examService->getLatestExamsBySchoolIdWithPagination();
        return view('exams.result.results', compact('exams'));
    }
    /**download result */
    public function downloadResultFile($exam_id) {
        $exam = Exam::findOrFail($exam_id);
        return Storage::disk('public')->download($exam->result_file);
    }

     /**remove exam result file*/
     public function removeResultFile($exam_id) {
        $exam = Exam::findOrFail($exam_id);

        if (!empty($exam->result_file)) {
            Storage::disk('public')->delete($exam->result_file);
        }

        $exam->result_file = '';
        $exam->save();

        return back()->with('status', 'Result file deleted');
    }
}

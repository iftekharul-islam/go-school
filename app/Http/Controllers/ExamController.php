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
use App\Myclass;
use App\Section;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService)
    {
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

        return view('exams.all', compact('exams'));
    }

    public function indexActive()
    {
        $exams                      = $this->examService->getActiveExamsBySchoolId();
        $this->examService->examIds = $exams->pluck('id')->toArray();
        $courses                    = $this->examService->getCoursesByExamIds();

        return view('exams.active', compact('exams', 'courses'));
    }

    public function details($exam_id)
    {
        $exams                      = $this->examService->getActiveExamsBySchoolId();
        $this->examService->examIds = $exams->pluck('id')->toArray();
        $courses                    = $this->examService->getCoursesByExamIds();

        return view('exams.details', compact('exam_id', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes                  = $this->examService->getClassesBySchoolId();
        $already_assigned_classes = $this->examService->getAlreadyAssignedClasses();
        $exams                    = $this->examService->getLatestExamsBySchoolIdWithPagination();

        return view('exams.add', compact('classes', 'already_assigned_classes', 'exams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExamRequest $request)
    {
        $this->examService->request = $request;
        try {
            $this->examService->storeExam();
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }

        return redirect()->route('exams')->with('status', 'New Exam Created');
    }

    /**
     * Display the specified resource.
     *
     * @param   int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam                     = Exam::with('myClasses', 'myClasses.classDetails')->findOrFail($id);
        $classes                  = $this->examService->getClassesBySchoolId();
        $already_assigned_classes = $this->examService->getAlreadyAssignedClasses();
        $exams                    = $this->examService->getLatestExamsBySchoolIdWithPagination();

        return view('exams.edit', compact('classes', 'already_assigned_classes', 'exams', 'exam'));
    }

    public function updateExam(UpdateExamDetailsRequest $request, $id)
    {
        $exam             = Exam::with('myClasses.classDetails')->findOrFail($id);
        $exam->term       = !empty($request->get('other_term')) ? $request->get('other_term') : $request->get('term');
        $exam->exam_name  = $request->get('exam_name');
        $exam->start_date = $request->get('start_date');
        $exam->end_date   = $request->get('end_date');
        $exam->save();

        $exists = [];
        foreach ($exam->myClasses as $item) {
            $exists[] = $item->class_id;
        }
        $id_deleted = [];

        if (isset($request->classes)) {
            foreach ($request->classes as $item) {
                $data         = ExamForClass::firstOrCreate([
                    'exam_id'  => $id,
                    'class_id' => $item,
                ]);
                $data->active = 1;
                $data->save();
                array_push($id_deleted, $item);
            }
        }
        $uselessData = array_diff($exists, $id_deleted);
        if ($uselessData) {
            $examForClass = ExamForClass::whereIn('class_id', $uselessData)->where('exam_id', $id)->delete();
        }

        return redirect()->route('exams')->with('status', 'Exam record updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   int                       $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|numeric',
        ]);
        try {
            $this->examService->request = $request;
            $this->examService->updateExam();
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }

        return back()->with('status', 'Exam record updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        $examForClass = ExamForClass::where('exam_id', $id)->get();
        $courses      = Course::where('exam_id', $id)->get();
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
    public function updateResultFile(UploadExamResultRequest $request, $exam_id)
    {
        $exam = Exam::findOrFail($exam_id);

        if (!empty($exam->result_file)) {
            Storage::disk('public')->delete($exam->result_file);
        }

//        $path              = Storage::disk('public')->put('result', $request->file('result_file'));
//        $exam->result_file = $path;
//        $exam->save();

        $file      = $request->file('result_file');
        $fileName          = $request->exam_name . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path              = $file->storeAs('public/result', $fileName);
        $exam->result_file = $path;
        $exam->save();

        return redirect()->route('exams.results')->with('status', 'Result file uploaded');
    }

    /**edit exam result file*/
    public function editResultFile($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);

        return view('exams.result.upload-result', compact('exam'));
    }

    /**upload exam result file*/
    public function resultFiles()
    {
        $exams = $exams = $this->examService->getLatestExamsBySchoolIdWithPagination();

        return view('exams.result.results', compact('exams'));
    }

    /**remove exam result file*/
    public function removeResultFile($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);

        if (!empty($exam->result_file)) {
            Storage::disk('public')->delete($exam->result_file);
        }

        $exam->result_file = '';
        $exam->save();

        return back()->with('status', 'Result file deleted');
    }

    /**Add exam attendees
     *
     * @param   int  $exam_id
     *
     * @return \Illuminate\Http\Response
     */
    public function addAttendee(Request $request, $exam_id)
    {
        $exam   = Exam::findOrFail($exam_id);
        $search = $request->class_id ? $request->class_id : '';

        $relatedClassIds = ExamForClass::where('exam_id', $exam->id)->groupBy('class_id')->pluck('class_id')->toArray();
        $relatedClasses  = Myclass::whereIn('id', $relatedClassIds)->get();

        $students = User::join('sections', 'sections.id', 'users.section_id')
            ->join('classes', 'sections.class_id', 'classes.id')
            ->whereIn('sections.class_id', $relatedClassIds)
            ->where('users.role', 'student')
            ->when($exam->attendees, function ($query) use ($exam) {
                $query->whereNotIn('users.id', unserialize($exam->attendees));
            })
            ->select('users.id', 'users.name', 'users.student_code', 'sections.section_number',
                'sections.id as section_id', 'classes.class_number')
            ->paginate(30);

        return view('exams.attendee.addAttendees', compact('exam', 'students', 'relatedClasses', 'search'));
    }

    /**Attendees
     *
     * @param   int  $exam_id
     *
     * @return \Illuminate\Http\Response
     */
    public function attendees($exam_id)
    {
        $exam     = Exam::findOrFail($exam_id);
        $students = '';
        if ($exam->attendees) {
            $students = User::with('section.class')->whereIn('id', unserialize($exam->attendees))->paginate(30);
        }

        return view('exams.attendee.attendees', compact('exam', 'students'));
    }

    /**Store Attendees
     *
     * @param   int  $exam_id
     *
     * @return \Illuminate\Http\Response
     */
    public function storeAttendees(Request $request, $exam_id)
    {
        $exam = Exam::findOrFail($exam_id);

        if (empty($request->user_ids)) {
            return back()->with('status', 'No Student Selected');
        }

        $oldAttendees    = !empty($exam->attendees) ? unserialize($exam->attendees) : [];
        $newAttendees    = $request->user_ids;
        $newAttendees    = array_merge($newAttendees, $oldAttendees);
        $newAttendees    = array_unique($newAttendees);
        $exam->attendees = serialize($newAttendees);
        $exam->save();

        return back()->with('status', 'Attendee(s) Added');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOnlineClassScheduleRequest;
use App\Jobs\SendSmsToStudents;
use App\Myclass;
use App\OnlineClassSchedule;
use App\OnlineClassSummary;
use App\Section;
use App\Services\User\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaraCrafts\UrlShortener\UrlShortenerManager;

class OnlineClassScheduleController extends Controller
{
    /**
     * OnlineClassScheduleController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = OnlineClassSchedule::with('section.class')->get();
        return view('online-class.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, UrlShortenerManager $shortener)
    {
        $url = $request->url ?? '';
        $tinyUrl = isset($request->url) ? $shortener->shorten($request->url) : '';
        $data = Section::with('class')->find($request->section_id);
        $class_number = $data->class->class_number ?? '';
        $section_id = $request->section_id ?? '';
        $section_number = $data->section_number ?? '';

        $classes = Myclass::with('sections')->where('school_id', Auth::user()->school_id)->get();
        $students = $this->userService->getSectionStudentsWithSchool($request->section);

        return view('online-class.create', compact('students', 'classes', 'class_number', 'section_number', 'section_id', 'url', 'tinyUrl'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOnlineClassScheduleRequest $request)
    {
        $students = User::where('section_id', $request->sec_id)
            ->where('role', 'student')
            ->where('active', 1)->pluck('id');


        $data = new OnlineClassSchedule();
        $data->user_id = Auth::user()->id;
        $data->section_id = $request->sec_id;
        $data->message = $request->message;
        $data->save();

        $summary = new OnlineClassSummary();
        $summary->class_schedules_id = $data->id;
        $summary->total_sms = count($students) * $request->sms_count;
        $summary->save();

        foreach ($students as $student_id) {
            SendSmsToStudents::dispatch($student_id, $request->message)->delay(5);
        }

        return redirect()->route('class.schedule')->with('status', 'Online class sms sent successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\OnlineClassSchedule $onlineClassSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $data = OnlineClassSchedule::with('classSummary', 'section.class')->findOrFail($id);

        return view('online-class.show', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\OnlineClassSchedule $onlineClassSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(OnlineClassSchedule $onlineClassSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\OnlineClassSchedule $onlineClassSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OnlineClassSchedule $onlineClassSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\OnlineClassSchedule $onlineClassSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(OnlineClassSchedule $onlineClassSchedule)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOnlineClassScheduleRequest;
use App\Jobs\SendSmsToStudents;
use App\Myclass;
use App\OnlineClassSchedule;
use App\OnlineClassSummary;
use App\School;
use App\Section;
use App\Services\User\UserService;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaraCrafts\UrlShortener\UrlShortenerManager;

class OnlineClassScheduleController extends Controller
{

    protected $userService;

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

        return view('online_class.index', compact('items'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $classes = Myclass::with('sections')->where('school_id', Auth::user()->school_id)->get();

        $data = Section::with('class')->find($request->section_id);

        $class_number = isset($data) ? $data->class->class_number : '';
        $section_id = isset($data) ? $data->id : '';
        $section_number = isset($data) ? $data->section_number : '';
        $students = isset($data) ? $this->userService->getSectionStudentsWithSchool($section_id) : [];


        return view('online_class.create', compact('students', 'classes', 'class_number', 'section_number', 'section_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOnlineClassScheduleRequest $request)
    {
        $school = School::find(Auth::user()->school_id);

        if ($school->online_class_sms == false) {

            return redirect()->route('class.schedule')->withErrors(__('text.online_sms_notification'));

        }

        $students = User::where('section_id', $request->sec_id)
            ->where('role', 'student')
            ->where('active', 1)
            ->pluck('id');


        $data = new OnlineClassSchedule();
        $data->user_id = Auth::user()->id;
        $data->section_id = $request->sec_id;
        $data->message = urlencode($request->message);
        $data->save();

        $summary = new OnlineClassSummary();
        $summary->class_schedule_id = $data->id;
        $summary->total_sms = count($students) * $request->sms_count;
        $summary->save();

        foreach ($students as $student_id) {

            SendSmsToStudents::dispatch($student_id, $request->message)->delay(5);
        }

        return redirect()->route('class.schedule')->with('status', __('text.online_sms_success_notification'));
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

        return view('online_class.show', compact('data'));

    }

    /**
     * @param UrlShortenerManager $shortener
     * @param Request $request
     * @return string
     */
    public function generateTinyUrl(UrlShortenerManager $shortener, Request $request)
    {

        $response = isset($request->tiny_url) ? $shortener->shorten(urldecode($request->tiny_url)) : '';

        return response()->json(['status' => 200, 'url' => urlencode($response)]);
    }
}

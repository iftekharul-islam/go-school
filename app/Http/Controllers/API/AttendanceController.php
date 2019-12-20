<?php

namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use App\Attendance;
use App\Configuration;
use Illuminate\Http\Request;
use App\Jobs\SendAttendanceSms;
use App\Events\AttendanceCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\AttendanceStoreRequest;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(AttendanceStoreRequest $request)
    {
        
        Logger("working: ");
        Logger($request->all());
        $student = User::where('student_code', $request->student_code)->first();

        // Logger("Student: " . $student);

        $today = Carbon::today();

        if (!$student) {
            return response([
                'error' => true,
                'massage' => 'No student found!'
            ]);
        }

        //for test

        // $attendance = Attendance::create([
        //     'student_id' => $student->id,
        //     'section_id' => $student->section->id,
        //     'exam_id' => 0,
        //     'present' => 1,
        //     'user_id' => 0
        // ]);

        // event(new AttendanceCreated($attendance, 'create'));

        // return response([
        //     'error' => false,
        //     'massage' => 'Attendance added successfully!'
        // ]);

        //end for test

        $attendance = Attendance::whereDate('created_at', Carbon::today())
                                ->where('student_id', $student->id)->first();

        if ($attendance) {
            // Add 1 hour to the existing attendance time
            $exitTimeConfig = Configuration::where('school_id', $student->school_id)->where('key', 'exit_time')->first();
            
            $exitTime = Carbon::parse($exitTimeConfig->value);

            if (Carbon::now()->gte($exitTime) ) {

                if (!$attendance->is_exit_message_sent) {
                    event(new AttendanceCreated($attendance, 'update'));

                    Logger('Student left for today!');

                    return response([
                        'error' => false,
                        'massage' => 'Student left for today!'
                    ]);
                }

                Logger('Student left already!');
    
                return response([
                    'error' => false,
                    'massage' => 'Student left already'
                ]);
            }
    
            return response([
                'error' => true,
                'massage' => 'Attendance already added!'
            ]);
        }

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'section_id' => $student->section->id,
            'exam_id' => 0,
            'present' => 1,
            'user_id' => 0
        ]);

        event(new AttendanceCreated($attendance, 'create'));

        Logger('Attendance added successfully!');

        return response([
            'error' => false,
            'massage' => 'Attendance added successfully!'
        ]);
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

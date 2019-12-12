<?php

namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use App\Attendance;
use Illuminate\Http\Request;
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
        // return 'hello';
        // return $request->all();
        $student = User::where('student_code', $request->student_code)->first();

        // return $student;

        // return Attendance::all();

        $today = Carbon::today();
        

        // return $today;

        if (!$student) {
            return response([
                'error' => true,
                'massage' => 'No student found!'
            ]);
        }

        $attendance = Attendance::whereDate('created_at', Carbon::today())
                                ->where('student_id', $student->id)->first();

        // return  $attendance;

        
        

        if ($attendance) {
            // Add 1 hour to the existing attendance time
            $time = Carbon::parse($attendance->created_at)->addHour();
            if (Carbon::now()->gt($time) ) {

                Attendance::create([
                    'student_id' => $student->id,
                    'section_id' => $student->section->id,
                    'exam_id' => 0,
                    'present' => 1,
                    'user_id' => 0
                ]);
    
                return response([
                    'error' => false,
                    'massage' => 'Attendance added successfully!'
                ]);
            }
    
            return response([
                'error' => true,
                'massage' => 'Attendance already added!'
            ]);
        }

        Attendance::create([
            'student_id' => $student->id,
            'section_id' => $student->section->id,
            'exam_id' => 0,
            'present' => 1,
            'user_id' => 0
        ]);

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

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
use App\SectionMeta;
use App\StudentInfo;
use App\StuffAttendance;
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
        $user = User::with('studentInfo')->where('student_code', $request->student_code)->first();

        if (!$user) {
            return response([
                'error' => true,
                'massage' => 'No user found!'
            ]);
        }

        $today = Carbon::today();

        if ( $user->role == 'student' ) 
        { 
            return $this->studentAttendance($user);
        } elseif( $user->role == 'teacher' ) {
            return $this->teacherAttendance($user);
        }
    }

    public function studentAttendance($student)
    {
        $attendance = Attendance::whereDate('created_at', Carbon::today())->where('student_id', $student->id)->first();
        $sectionMeta = SectionMeta::where('section_id', $student->section_id)->where('shift', $student->studentInfo->shift)->first();
        
        $exitTimeConfig = Configuration::where('school_id', $student->school_id)->where('key', 'exit_time')->first();
        $entryTimeConfig = Configuration::where('school_id', $student->school_id)->where('key', 'last_attendance_time')->first();
         
        if ($sectionMeta) {
            $exitTime = Carbon::parse($sectionMeta->exit_time);
            $last_attendance_time = Carbon::parse($sectionMeta->last_attendance_time);
            
        } else {
            $exitTime = Carbon::parse($exitTimeConfig->value);
            $last_attendance_time = Carbon::parse($entryTimeConfig->value);
        }
        
        if ($attendance) {
            if ( Carbon::now()->gte($exitTime) ) {
                if (!$attendance->is_exit_message_sent) {
                    event(new AttendanceCreated($attendance, 'update'));

                    Logger('Student left for today!');

                    return response([
                        'error' => false,
                        'massage' => 'Student left for today!'
                    ]);
                }
            }
            Logger('Attendance Already Added!');
    
            return response([
                'error' => false,
                'massage' => 'Attendance Already Added!'
            ]);
        } else {
            if (Carbon::now()->lte($last_attendance_time)) {
                $studentData = [
                    'student_id' => $student->id,
                    'section_id' => $student->section->id,
                    'exam_id' => 0,
                    'present' => 1,
                    'user_id' => 0
                ];
                $attendance = Attendance::create($studentData);
        
                event(new AttendanceCreated($attendance, 'create'));
        
                Logger('Attendance added successfully!');
        
                return response([
                    'error' => false,
                    'massage' => 'Attendance added successfully!'
                ]);
            } elseif ( Carbon::now()->gte($exitTime) ) {
                Logger('Student left for today!');

                return response([
                    'error' => false,
                    'massage' => 'Student left for today!'
                ]);
            }

            Logger('Last Attendance Time Crossed!');

            return response([
                'error' => true,
                'massage' => 'Last Attendance Time Crossed!'
            ]);
        }
    }

    public function teacherAttendance($staff)
    {
        $exitTimeConfig = Configuration::where('school_id', $staff->school_id)->where('key', 'exit_time')->first();
        $entryTimeConfig = Configuration::where('school_id', $staff->school_id)->where('key', 'last_attendance_time')->first();
        $exit_time = Carbon::parse($exitTimeConfig->value);
        $last_attendance_time = Carbon::parse($entryTimeConfig->value);
        
        $attendance = StuffAttendance::whereDate('created_at', Carbon::today())->where('stuff_id', $staff->id)->first();
       
        if ($attendance) {
            if ( Carbon::now()->gte($exit_time) ) {
                Logger('Staff left for today!');

                return response([
                    'error' => false,
                    'massage' => 'Staff left for today!'
                ]);
            }

            Logger('Attendance Already Added!');
    
            return response([
                'error' => false,
                'massage' => 'Attendance Already Added!'
            ]);
        } elseif (Carbon::now()->lte($last_attendance_time)) {
            $staffAttendance = new StuffAttendance();
            $staffAttendance->school_id = $staff->school_id;
            $staffAttendance->stuff_id = $staff->id;
            $staffAttendance->present = 1;
            $staffAttendance->role = $staff->role;
            $staffAttendance->user_id = $staff->id;
            $staffAttendance->save();
    
            return response([
                'error' => false,
                'massage' => 'Staff Attendance Added Sucessfully!'
            ]);
        } elseif ( Carbon::now()->gte($exit_time) ) {
            Logger('Staff left for today!');

            return response([
                'error' => false,
                'massage' => 'Staff left for today!'
            ]);
        }
        
        return response([
            'error' => true,
            'massage' => 'Attendance Time Crossed!'
        ]);
    }

}

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
            if ( empty($attendance->exit_time) ) {
                $attendance->exit_time = Carbon::now()->format('Y-m-d H:i:s');
                $attendance->save();
                
                #send SMS
                event(new AttendanceCreated($attendance, 'update'));
                
                Logger('Student left for today!');

                return response([
                    'error' => false,
                    'massage' => 'Student left for today!'
                ]);
            }
            Logger('Student Attendance Already Added!');
    
            return response([
                'error' => false,
                'massage' => 'Student Attendance Already Added!'
            ]);
        } else {
            $studentData = [
                'student_id' => $student->id,
                'section_id' => $student->section->id,
                'exam_id' => 0,
                'present' => Carbon::now()->lte($last_attendance_time) ? 1 : 3,
                'user_id' => $student->id
            ];

            $attendance = Attendance::create($studentData);
            #send SMS
            event(new AttendanceCreated($attendance, 'create'));

            Logger('Student atendance added successfully!');

            return response([
                'error' => false,
                'massage' => 'Student attendance added successfully!'
            ]);
        }
    }

    public function teacherAttendance($staff)
    {
        $staff->load('shift');
        $attendance = StuffAttendance::whereDate('created_at', Carbon::today())->where('stuff_id', $staff->id)->first();
        $exitTimeConfig = Configuration::where('school_id', $staff->school_id)->where('key', 'exit_time')->first();
        $entryTimeConfig = Configuration::where('school_id', $staff->school_id)->where('key', 'last_attendance_time')->first();
        $exit_time = Carbon::parse($exitTimeConfig->value);
        $last_attendance_time = Carbon::parse($entryTimeConfig->value);

        if ($staff['shift']) {
            $exit_time = Carbon::parse($staff->shift['exit_time']);
            $last_attendance_time = Carbon::parse($staff->shift['last_attendance_time']);
        }

        if ($attendance) {
            if ( empty($attendance->exit_time) ) {
                Logger('Staff left for today!');
                
                $attendance->exit_time = Carbon::now()->format('Y-m-d H:i:s');
                $attendance->save();
                
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
        } else {
            $staffAttendance = new StuffAttendance();
            $staffAttendance->school_id = $staff->school_id;
            $staffAttendance->stuff_id = $staff->id;
            $staffAttendance->present = Carbon::now()->lte($last_attendance_time) ? 1 : 3;
            $staffAttendance->role = $staff->role;
            $staffAttendance->user_id = $staff->id;
            $staffAttendance->save();

            return response([
                'error' => false,
                'massage' => 'Staff Attendance Added Sucessfully!'
            ]);
        }
    }
}

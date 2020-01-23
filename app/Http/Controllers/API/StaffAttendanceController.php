<?php

namespace App\Http\Controllers\API;

use App\Configuration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\AttendanceStoreRequest;
use App\StuffAttendance;
use App\User;
use Carbon\Carbon;

class StaffAttendanceController extends Controller
{
    public function store(AttendanceStoreRequest $request)
    {
        $staff = User::where('student_code', $request->student_code)->first();
        if (!$staff) {
            return response([
                'error' => true,
                'massage' => 'No student found!'
            ]);
        }

        $exitTimeConfig = Configuration::where('school_id', $staff->school_id)->where('key', 'exit_time')->first();
        $entryTimeConfig = Configuration::where('school_id', $staff->school_id)->where('key', 'last_attendance_time')->first();
        $exit_time = Carbon::parse($exitTimeConfig->value);
        $last_attendance_time = Carbon::parse($entryTimeConfig->value);
        $attendance = StuffAttendance::whereDate('created_at', Carbon::today())->where('stuff_id', $staff->id)->first();
       
        if ($attendance) {
            if (Carbon::now()->gte($exit_time) ) {
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
        }elseif(Carbon::now()->lte($last_attendance_time)) {
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
        }elseif ( Carbon::now()->gte($exit_time) ) {
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

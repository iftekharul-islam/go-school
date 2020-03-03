<?php

namespace App\Listeners;

use App\Attendance;
use App\Events\NewUserRegistered;
use App\StuffAttendance;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class AttendanceStore
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        if ($event->user->role == 'student')
        {
            $Attendance = new Attendance();
            $Attendance->student_id = $event->user->id;
            $Attendance->section_id = $event->user->section_id;
            $Attendance->exam_id = 0;
            $Attendance->user_id = Auth::user()->id;
            $Attendance->present = '0';
            $Attendance->save();
        }elseif ($event->user->role == 'teacher' || 'accountant' || 'librarian' )
        {
            $staffAttendance = new StuffAttendance();
            $staffAttendance->school_id = Auth::user()->school_id;
            $staffAttendance->stuff_id = $event->user->id;
            $staffAttendance->present = '0';
            $staffAttendance->role = $event->user->role;
            $staffAttendance->user_id = Auth::user()->id;
            $staffAttendance->save();
        }
    }
}

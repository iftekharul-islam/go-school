<?php

namespace App\Listeners;


use App\Attendance;
use App\Events\ImportStudentAttendance;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class AttendanceInfoStore
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
    public function handle(ImportStudentAttendance $event)
    {
        $Attendance = new Attendance();
        $Attendance->student_id = $event->user->id;
        $Attendance->section_id = $event->user->section_id;
        $Attendance->exam_id = 0;
        $Attendance->user_id = Auth::user()->id;
        $Attendance->present = '0';
        $Attendance->save();
    }
}

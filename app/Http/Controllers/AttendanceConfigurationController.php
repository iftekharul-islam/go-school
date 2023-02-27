<?php

namespace App\Http\Controllers;

use App\AttendanceConfiguration;
use Illuminate\Http\Request;

class AttendanceConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('attendance.configAttendance.attendance-time');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendance.configAttendance.add-attendance-time');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AttendanceConfiguration  $attendanceConfiguration
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceConfiguration $attendanceConfiguration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AttendanceConfiguration  $attendanceConfiguration
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceConfiguration $attendanceConfiguration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AttendanceConfiguration  $attendanceConfiguration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendanceConfiguration $attendanceConfiguration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AttendanceConfiguration  $attendanceConfiguration
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceConfiguration $attendanceConfiguration)
    {
        //
    }
}

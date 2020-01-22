<?php

namespace App\Http\Controllers;

use App\Myclass;
use App\SectionMeta;
use Illuminate\Http\Request;
use App\Http\Requests\attendanceTiming\CreateAttendanceTimeRequest;
use App\Http\Requests\attendanceTiming\UpdateAttendanceTimeRequest;

class SectionMetaController extends Controller
{
    public function index()
    {
        $classes = Myclass::with('sections.attendanceTimes')->where('school_id', \auth::user()->school_id)->get();
        return view('attendance.configAttendance.attendance-time', compact('classes'));
    }

    public function create()
    {
        $classes = Myclass::with('sections')->where('school_id', \auth::user()->school_id)->get();
        return view('attendance.configAttendance.add-attendance-time', compact('classes'));
    }

    public function store(CreateAttendanceTimeRequest $request)
    {
        $isExists = $this->checkSectionShift($request->get('section_id'), $request->get('shift'));
        if ($isExists){
            return back()->withInput()->with('error','Section exists with the shift: '.ucfirst($request->get('shift')));
        }
        SectionMeta::create($request->all());
        return back()->with('status', 'Attendance time added');
    }

    public function show(SectionMeta $sectionMeta)
    {
        //
    }
    
    public function edit($id)
    {
        $classes = Myclass::with('sections.attendanceTimes')->where('school_id', \auth::user()->school_id)->get();
        $sectionMeta = SectionMeta::findOrFail($id);
        return view('attendance.configAttendance.edit-attendance-time', compact('classes', 'sectionMeta'));
    }

    public function update(UpdateAttendanceTimeRequest $request, $id)
    {
        $isExists = $this->checkSectionShift($request->get('section_id'), $request->get('shift'), $id);
        if ($isExists){
            return back()->withInput()->with('error','Section exists with the shift: '.ucfirst($request->get('shift')));
        }
        $sectionMeta = SectionMeta::findOrFail($id);
        $sectionMeta->section_id = $request->get('section_id');
        $sectionMeta->last_attendance_time = $request->get('last_attendance_time');
        $sectionMeta->exit_time = $request->get('exit_time');
        $sectionMeta->save();
        return back()->with('status','Attendance timing updated');
    }

    public function destroy($id)
    {
        $sectionMeta = SectionMeta::findOrFail($id);
        $sectionMeta->delete();
        return back()->with('status','Attendance Timing Deleted');
    }
    protected function checkSectionShift($section_id,$shift,$skipRow=null){
        $count = SectionMeta::where('section_id', $section_id)
            ->where('shift', $shift)
            ->when($skipRow, function($query) use ($skipRow){
                return $query->where('id','<>',$skipRow);
            })
            ->count();
        if ($count > 0){
            return true;
        }
        return false;
    }
}

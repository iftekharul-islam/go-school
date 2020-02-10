<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shift\CreateShiftRequest;
use App\Http\Requests\Shift\UpdateShiftRequest;
use App\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts = Shift::orderby('shift', 'asc')->where('school_id', Auth::user()->school_id)->paginate(30);
        return view('shift.shifts', compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shift.add-shift');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateShiftRequest $request)
    {
        $shift = new Shift();
        $shift->shift = $request->get('shift');
        $shift->last_attendance_time = $request->get('last_attendance_time');
        $shift->exit_time = $request->get('exit_time');
        $shift->school_id = Auth::user()->school_id;
        $shift->save();

        return redirect()->route('shifts')->with('status', 'Shift created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        return view('shift.edit-shift', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShiftRequest $request, $id)
    {
        $shift = Shift::findOrFail($id);
        $shift->shift = $request->get('shift');
        $shift->last_attendance_time = $request->get('last_attendance_time');
        $shift->exit_time = $request->get('exit_time');
        $shift->save();

        return redirect()->route('shifts')->with('status', 'Shift updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $shiftName = $shift->shift;
        $shift->delete();

        return back()->with('status', $shiftName.' shift deleted' );
    }
}

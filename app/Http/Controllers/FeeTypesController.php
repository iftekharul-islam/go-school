<?php

namespace App\Http\Controllers;

use App\FeeType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeTypes = FeeType::where('school_id', Auth::user()->school_id)->get();
        return view('accounts.feeTypes.index', compact('feeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.feeTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'desc' => 'required',
        ]);

        $today = Carbon::now();
        $feeType = new FeeType();
        $feeType->name = $request->get('name');
        $feeType->code = $request->get('code');
        $feeType->description = $request->get('desc');
        $feeType->school_id = Auth::user()->school_id;
        $feeType->type = 'onetime';
        $feeType->year = $today->year;
        $feeType->save();
        return redirect(\auth()->user()->role.'/fee-types')->with('status', 'Fee types Created');
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
        $feeType = FeeType::findOrFail($id);
        return view('accounts.feeTypes.edit', compact('feeType'));
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
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'desc' => 'required',
        ]);

        $feeType = FeeType::findOrFail($id);
        $feeType->name = $request->get('name');
        $feeType->code = $request->get('code');
        $feeType->description = $request->get('desc');
        $feeType->save();
        return redirect(\auth()->user()->role.'/fee-types')->with('status', 'Fee types Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feeType = FeeType::findOrFail($id);
        $feeType->delete();
        return redirect(\auth()->user()->role.'/fee-types')->with('status', 'Fee types Deleted');
    }
}

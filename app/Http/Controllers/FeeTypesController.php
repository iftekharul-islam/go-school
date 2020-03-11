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
        $feeTypes = FeeType::where('school_id', Auth::user()->school_id)->orWhere('is_default', 1)->get();
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
            'code' => 'required'
        ]);

        $today = Carbon::now();
        $feeType = new FeeType();
        $feeType->name = $request->get('name');
        $feeType->code = $request->get('code');
        $feeType->description = $request->get('desc');
        $feeType->type = $request->get('type') == 1 ? 'monthly' : 'onetime';
        $feeType->year = $today->year;
        $feeType->school_id = Auth::user()->school_id;
        if (Auth::user()->role == 'master') {
            $feeType->is_default = 1;
        }
        $feeType->save();
        return back()->with('status', 'Fee types Created');
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
        return back()->with('status', 'Fee Type Updated');
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
        return back()->with('status', 'Fee Type Deleted');
    }

    public function defaultFeeTypes()
    {
        $feeTypes = FeeType::where('is_default', 1)->get();
        return view('accounts.feeTypes.default', compact('feeTypes'));
    }
}

<?php

namespace App\Http\Controllers;

use App\FeeMaster;
use App\FeeType;
use App\Myclass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $feeMasters = FeeMaster::all();
        $classes = Myclass::where('school_id', Auth::user()->school_id)->get();
        return view('accounts.feeMaster.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Myclass::where('school_id', Auth::user()->school_id)->get();
        $feeTypes = FeeType::where('type', '!=', 'recurrent')->where('school_id', Auth::user()->school_id)->get();
        return view('accounts.feeMaster.create', compact('classes', 'feeTypes'));
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
            'class_id' => 'required',
            'fee_type' => 'required',
            'amount' => 'required',
            'dueDate' => 'required',
        ]);
        if ($request->fee_type === 'recurrent') {
            $feeTypes = FeeType::where('type', 'recurrent')->get();
//          return $feeTypes;
            $string = $request->dueDate;
            $timestamp = strtotime($string);
            $dueDate =  date("d", $timestamp);
            foreach ($feeTypes as $feeType) {
                $feeMaster = new FeeMaster();
                $feeMaster->class_id = $request->get('class_id');
                $feeMaster->fee_type_id = $feeType->id;
                $feeMaster->due = $dueDate;
                $feeMaster->amount = $request->get('amount');
                $feeMaster->format = 'recurrent';
                $feeMaster->save();
            }
        } else {
            $feeMaster = new FeeMaster();
            $feeMaster->class_id = $request->get('class_id');
            $feeMaster->fee_type_id = $request->fee_type;
            $feeMaster->due = $request->get('dueDate');
            $feeMaster->amount = $request->get('amount');
            $feeMaster->format = 'onetime';
            $feeMaster->save();
        }
        return redirect(auth()->user()->role.'/fee-master')->with('status', 'Fee Master Created');
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
        $feeMaster = FeeMaster::findOrFail($id);
        $classes = Myclass::all();
        $feeTypes = FeeType::where('school_id', Auth::user()->school_id)->get();
        return view('accounts.feeMaster.edit', compact('feeMaster', 'classes', 'feeTypes'));
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
            'class_id' => 'required',
            'fee_type' => 'required',
            'amount' => 'required',
            'dueDate' => 'required',
            'format' => 'required',
        ]);
        $feeMaster = FeeMaster::findOrFail($id);
        $feeMaster->class_id = $request->get('class_id');
        $feeMaster->fee_type_id = $request->get('fee_type');
        $feeMaster->due = $request->get('dueDate');
        $feeMaster->amount = $request->get('amount');
        $feeMaster->format = $request->get('format');
        $feeMaster->save();
        return redirect(auth()->user()->role.'/fee-master')->with('status', 'Fee Master Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feeMaster = FeeMaster::findOrFail($id);
        $feeMaster->delete();
        return redirect(auth()->user()->role.'/fee-master')->with('status', 'Fee Master Deleted');
    }

    public function classFee(Request $request)
    {
        $classes = Myclass::where('school_id', Auth::user()->school_id)->get();
        $feeMasters = FeeMaster::where('class_id', $request->class)->get();
        return view('accounts.feeMaster.index', compact('feeMasters', 'classes'));
    }
}

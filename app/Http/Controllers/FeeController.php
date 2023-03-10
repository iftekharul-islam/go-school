<?php

namespace App\Http\Controllers;

use App\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $fees = Fee::where('school_id', Auth::user()->school_id)->get();
      return view('fees.new-all',['fees'=>$fees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fees.new-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        $request->validate([
            'fee_name' => 'required|string|max:255',
        ]);
        $fee = new Fee;
        $fee->fee_name = $request->fee_name;
        $fee->school_id = $user->school_id;
        $fee->user_id = $user->id;
        $fee->save();
        return back()->with('status', 'Fee information stored');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fee = Fee::findOrFail($id);
        $fee->delete();
        return redirect()->back()->with('status', 'Removed');
    }
}

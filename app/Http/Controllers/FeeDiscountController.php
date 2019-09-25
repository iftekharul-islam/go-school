<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;

class FeeDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts =  Discount::all();
        return view('accounts.discount.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.discount.create');
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
            'amount' => 'required',
            'desc' => 'required',
        ]);

        $discount = new Discount();
        $discount->name = $request->get('name');
        $discount->code = $request->get('code');
        $discount->amount = $request->get('amount');
        $discount->description = $request->get('desc');
        $discount->school_id = auth()->user()->school_id;
        $discount->save();
        return redirect(auth()->user()->role.'/fee-discount')->with('status', 'Discount Created');
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
        $discount = Discount::findOrFail($id);
        return view('accounts.discount.edit', compact('discount'));
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
            'amount' => 'required',
            'desc' => 'required',
        ]);
        $discount = Discount::findOrFail($id);
        $discount->name = $request->get('name');
        $discount->code = $request->get('code');
        $discount->amount = $request->get('amount');
        $discount->description = $request->get('desc');
        $discount->save();
        return redirect(auth()->user()->role.'/fee-discount')->with('status', 'Discount Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return redirect(auth()->user()->role.'/fee-discount')->with('status', 'Discount Deleted');
    }
}

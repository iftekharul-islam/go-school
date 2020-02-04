<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\CreatePaymentRequest;
use App\School;
use App\SchoolMeta;
use Illuminate\Http\Request;

class SchoolMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolMetas = SchoolMeta::with('school')->paginate(40);
        return view('payment.payment-details', compact('schoolMetas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schools = School::all();
        return view('payment.add-payment-detail', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePaymentRequest $request)
    {
        SchoolMeta::create($request->all());
        return back()->with('status', 'Payment Information Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolMeta  $schoolMeta
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolMeta $schoolMeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SchoolMeta  $schoolMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolMeta $schoolMeta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolMeta  $schoolMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolMeta $schoolMeta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolMeta  $schoolMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schoolMeta = SchoolMeta::findOrFail($id);
        $schoolMeta->delete();
        return back()->with('status', 'Payment info deleted');
    }
}

<?php

namespace App\Http\Controllers;

use App\SchoolMeta;
use App\SmsHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('payment.generate-invoice');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        //
    }
}

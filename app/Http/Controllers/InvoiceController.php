<?php

namespace App\Http\Controllers;

use App\Jobs\SendInvoice;
use App\Mail\InvoiceMail;
use App\School;
use App\SchoolMeta;
use App\SmsHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('payment.generate-invoice');
    }

    public function send(Request $request)
    {
        $request->validate(['month' => 'required']);
        
        $count = School::whereNotNull('email')->where('is_active', 1)->count();

        if($count > 0) {
            SendInvoice::dispatch($request->month);
            return back()->with('status', 'Invoice Sent!');
        }

        return back()->with('status', 'No School Found!');
    }
}

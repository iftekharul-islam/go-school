<?php

namespace App\Http\Controllers;

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
        $now = Carbon::now();
        $schools = School::with('schoolMeta')->where('is_active', 1)->get();
        if ( count($schools) > 0 ) {
            foreach ($schools as $school) {
                if (!empty($school['schoolMeta'])) { 
                    $data = [];
                    $totalStudent = User::where('school_id', $school->id)->where('active', 1)->count();
                    $totalSms = SmsHistory::where('school_id', $school->id)
                        ->whereMonth('created_at', $request->get('month'))    
                        ->whereYear('created_at', $now->year)    
                        ->count();
                    $smsCost = $school['schoolMeta']['sms_charge'] * $totalSms;
                    $serviceCharge = $school['schoolMeta']['per_student_charge'] * $totalStudent;
                    $data['totalStudent'] =  $totalStudent;
                    $data['totalSms'] =  $totalSms;
                    $data['per_sms_cost'] =   $school['schoolMeta']['sms_charge'];
                    $data['per_student_cost'] =   $school['schoolMeta']['per_student_charge'];
                    $data['schoolName'] =  $school->name;
                    $data['smsCost'] =  $smsCost;
                    $data['serviceCharge'] =  $serviceCharge;
                    $data['month'] =  date("F", mktime(0, 0, 0, $request->month, 1)) .' '. $now->format('Y');
                    $data['schoolAddress'] =  $school->school_address;
                    
                    Mail::to($school['schoolMeta']['email'])->send(new InvoiceMail($data));
                }
            }
            return back()->with('status', 'Invoice Sent!');
        }
        return back()->with('status', 'No School Found!');
    }
}

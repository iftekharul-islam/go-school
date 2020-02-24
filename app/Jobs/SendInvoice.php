<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\School;
use App\SmsHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $month;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($month)
    {
        $this->month = $month;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now();
        $schools = School::whereNotNull('email')->where('is_active', 1)->get();
       
        foreach ( $schools as $school ) {
            $data = [];
            $totalStudent = User::where('school_id', $school->id)->where('active', 1)->count();
            $totalSms = SmsHistory::where('school_id', $school->id)
                ->whereMonth('created_at', $this->month)    
                ->whereYear('created_at', $now->year)    
                ->count();
            $smsCost = $school['sms_charge'] * $totalSms;
            $serviceCharge = $school['per_student_charge'] * $totalStudent;
            $data['totalStudent'] =  $totalStudent;
            $data['totalSms'] =  $totalSms;
            $data['per_sms_cost'] =   $school['sms_charge'];
            $data['per_student_cost'] =   $school['per_student_charge'];
            $data['schoolName'] =  $school->name;
            $data['smsCost'] =  $smsCost;
            $data['serviceCharge'] =  $serviceCharge;
            $data['month'] =  date("F", mktime(0, 0, 0, $this->month, 1)) .' '. $now->format('Y');
            $data['schoolAddress'] =  $school->school_address;

            if ($school['email']) {
                Mail::to($school['email'])->send(new InvoiceMail($data));
            }
        }
    }
}

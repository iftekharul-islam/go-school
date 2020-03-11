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
            $totalStudent = User::where('school_id', $school->id)->where('active', 1)->where('role', 'student')->count();
            $totalSms = SmsHistory::where('school_id', $school->id)
                ->whereMonth('created_at', $this->month)    
                ->whereYear('created_at', $now->year)    
                ->count();

            $data['totalStudent'] =  $totalStudent;
            $data['totalSms'] =  $totalSms;
            $data['per_sms_cost'] =   $school['sms_charge'];
            $data['charge'] =   $school['charge'];
            $data['schoolName'] =  $school->name;
            $data['smsCost'] =  $school['sms_charge'] * $totalSms;
            $data['serviceCharge'] =  $school['charge'] * $totalStudent;
            $data['month'] =  date("F", mktime(0, 0, 0, $this->month, 1)) .' '. $now->format('Y');
            $data['schoolAddress'] =  $school->school_address;
            $data['payment_type'] = $school->payment_type;
            $data['is_sms_enable'] = $school->is_sms_enable;

            Mail::to($school['email'])->send(new InvoiceMail($data));
        }
    }
}

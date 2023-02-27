<?php

namespace App\Jobs;

use App\User;
use App\School;
use Carbon\Carbon;
use App\Attendance;
use App\SmsHistory;
use App\SchoolAbsent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AbsentMessageProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $school_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($school_id)
    {
        $this->school_id = $school_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $school = School::where('id', $this->school_id)->first();
        $msg = !empty($school->absent_msg) ? $school->absent_msg : null;
        if ($school->is_sms_enable != 1) {
            Logger('SMS not enabled for the school');
            return;
        }

        $students = User::where('school_id', $this->school_id)->where('role', 'student')->get();

        $attendedStudentIds = Attendance::whereDate('created_at', Carbon::today())->pluck('student_id');

        Logger('attendances ' . $attendedStudentIds);

        foreach($students as $student) {
            if(!in_array($student->id, $attendedStudentIds->toArray())) {
                Logger('Absent ' . $student->id);
                $this->sendSms($student, $msg);
                continue;
            }
            Logger('Present' . $student->id);
        }

        SchoolAbsent::create([
            'school_id' => $this->school_id,
            'status'    => true
        ]);
    }

    public function sendSms($student, $msg = null)
    {
        Logger('SMS sent');
        return;

        if(!$student->studentInfo['is_sms_enabled'])  {
          Logger('SMS not enabled');  
          return;
        }
        
        $phone = !empty($student->studentInfo['guardian_phone_number']) ?
            $student->studentInfo['guardian_phone_number'] : $student->studentInfo['father_phone_number'];

        $checked_digit = substr($phone, 0, 3);
        if ($checked_digit == '+88') {
            $phone = ltrim($phone, '+');
        } else {
            if ($checked_digit == '880') {
                $phone = $phone;
            } else {
                $phone = '88' . $phone;
            }
        }
        $user = config("message.sms_user");
        $pass = config("message.sms_pass");
        $sid = config("message.sms_sid");
        $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
        $message = !empty($msg) ? str_replace('[name]',$student->name, $msg)  : $student->name . " is absent in today's (" . Carbon::now()->toFormattedDateString() . ") class.";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'form_params' => [
                'user' => $user,
                'pass' => $pass,
                'sid'  => $sid,
                'sms'  => [
                    [$phone, $message],
                ],
            ],
        ]);

        SmsHistory::create([
            'content' => $message,
            'type'    => 'absent',
            'student_id' => $student->id,
            'school_id' => $student->school_id
        ]);

        Logger('response: ' . $response->getBody());
    }
}

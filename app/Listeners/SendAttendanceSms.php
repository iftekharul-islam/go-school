<?php

namespace App\Listeners;

use App\School;
use App\User;
use Carbon\Carbon;
use App\Attendance;
use App\SmsHistory;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use App\Http\Traits\CustomQueue;
use App\Events\AttendanceCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Monolog\Logger;

class SendAttendanceSms implements ShouldQueue
{
    use Queueable, CustomQueue;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AttendanceCreated $event)
    {
        Logger('env ' . config('app.env'));
        $this->sendSms($event);
    }


    public function sendSms($event)
    {
        $student = User::find($event->attendance['student_id']);
        $school = School::find($student->school_id);

        #don't send sms when sms disabled for the school
        if ($school->is_sms_enable != 1) {
            Logger('SMS not enabled for the school '. $school->name);
            return;
        }

        #don't send sms when sms disabled for the student
        if (!$student->studentInfo['is_sms_enabled'])  {
          Logger('SMS not enabled for student');
          return;
        }

        if ($event->status == 'create') {
            Logger('Student Enter');
            $text = " attended today's (";
            $type = "entry";
            $event->attendance->is_entry_message_sent = true;
            $event->attendance->save();
        } else {
            Logger('Student left');
            $text = " left today's (";
            $type = "exit";
            $event->attendance->is_exit_message_sent = true;
            $event->attendance->save();
        }

        $phone = !empty($student->studentInfo['guardian_phone_number']) ? $student->studentInfo['guardian_phone_number'] : $student->studentInfo['father_phone_number'];

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

        Logger('Sms Phone number ' . $phone);
        
//               $user = config("message.sms_user");
//        $pass = config("message.sms_pass");
//        $sid = config("message.sms_sid");
//        $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";

        $api_key = '$2y$10$nCixye2JmYu8p65XRv.yFeuMV4mc4BBko4KZ6XpmwEDiaEqfh1h2O';
        $base_url_non_masking = 'http://smscp.datasoftbd.com/smsapi/non-masking';

        $message = $student->name . $text . Carbon::now()->toFormattedDateString() . ") class.";

        #set message
        if ($type == 'entry') {
            if(!empty($school->present_msg)){
                $message = str_replace('[name]', $student->name, $school->present_msg);
            }
        }

        $url = $base_url_non_masking."?api_key=" . $api_key . "&smsType=text&mobileNo=" . $phone . "&smsContent=" . $message;
        $client = new Client();

        if (config('app.env') != 'production') {
            Logger('App is not in production');
            return;
        }

//        $response = $client->request('POST', $url, [
//            'form_params' => [
//                'user' => $user,
//                'pass' => $pass,
//                'sid'  => $sid,
//                'sms'  => [
//                    [$phone, $message],
//                ],
//            ],
//        ]);

        $response = $client->get($url);

        SmsHistory::create([
            'content' => $message,
            'type'    => $type,
            'student_id' => $student->id,
            'school_id' => $student->school_id
        ]);

        Logger('response: ' . $response->getBody());
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\OrderShipped  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(AttendanceCreated $event, $exception)
    {
        Logger('Failed ', $exception);
    }
}

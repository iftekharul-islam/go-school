<?php

namespace App\Listeners;

use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use App\Http\Traits\CustomQueue;
use App\Events\AttendanceCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        if (config('app.env') == 'production') {
            $this->sendSms($event->attendance);
        }
        
        
    }


    public function sendSms($attendance)
    {
        $student = User::find($attendance->student_id);

        if(!$student->studentInfo['is_sms_enabled'])  {
          Logger('SMS not enabled');  
          return;
        }
        
        $phone = $student->studentInfo['father_phone_number'];

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
        $phone = '8801960229599';
        $user = config("message.sms_user");
        $pass = config("message.sms_pass");
        $sid = config("message.sms_sid");
        $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'form_params' => [
                'user' => $user,
                'pass' => $pass,
                'sid'  => $sid,
                'sms'  => [
                    [$phone, $student->name . " attended today's (" . Carbon::now()->toFormattedDateString() . ") class."],
                ],
            ],
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

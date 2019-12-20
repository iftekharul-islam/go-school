<?php

namespace App\Listeners;

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

        if(!$student->studentInfo['is_sms_enabled'])  {
          Logger('SMS not enabled');  
          return;
        }

        // $attendance = Attendance::find($data['attendance']['id']);

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
        
        $user = config("message.sms_user");
        $pass = config("message.sms_pass");
        $sid = config("message.sms_sid");
        $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
        $message = $student->name . $text . Carbon::now()->toFormattedDateString() . ") class.";
        $client = new Client();

        if (config('app.env') != 'production') {
            Logger('App is not in production');
            return;
        }

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

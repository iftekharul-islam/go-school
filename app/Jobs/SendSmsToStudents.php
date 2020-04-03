<?php

namespace App\Jobs;

use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsToStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected  $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $message)
    {
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = strip_tags($this->message);
        $students = User::with('studentInfo')->whereIn('id', $this->data)->get();
        
        foreach ( $students as $student)
        {
            $phone = '';
            
            if (!empty($student['studentInfo']['guardian_phone_number'])) {
                $phone = $student['studentInfo']['guardian_phone_number'];
            } else {
                $phone = $student['studentInfo']['father_phone_number'];
            }

            
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
        }
    }
}

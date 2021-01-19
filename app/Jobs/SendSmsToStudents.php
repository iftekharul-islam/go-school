<?php

namespace App\Jobs;

use App\User;
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
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $message)
    {
        $this->data    = $data;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $base_url_non_masking = env('SMS_BASE_URL');
        $api_key              = env('SMS_API_KEY');
        $message              = urlencode($this->message);

//        $api_key = '$2y$10$nCixye2JmYu8p65XRv.yFeuMV4mc4BBko4KZ6XpmwEDiaEqfh1h2O';
//        $base_url_non_masking = 'https://smscp.datasoftbd.com/smsapi/non-masking';
//        $message = strip_tags($this->message);

        $student = User::with('studentInfo')->where('id', $this->data)->first();

        if ($student['studentInfo']['is_sms_enabled'] == 1) {
            $phone = $student['studentInfo']['father_phone_number'];
            if (!empty($student['studentInfo']['guardian_phone_number'])) {
                $phone = $student['studentInfo']['guardian_phone_number'];
            }

            $checked_digit = substr($phone, 0, 3);
            if ($checked_digit == '+88') {
                $phone = ltrim($phone, '+');
            }

            $checked_zero = substr($phone, 0, 1);
            if ($checked_zero == 0) {
                $phone = '88'.$phone;
            }

            $checked_lastest = substr($phone, 0, 3);
            if ($checked_lastest !== '880') {
                $phone = ltrim($phone, '88');
                $phone = '880'.$phone;
            }

//            $url = $base_url_non_masking . "?api_key=" . $api_key . "&smsType=text&mobileNo=" . $phone . "&smsContent=" . $message;

            // datasoftbd url
            $url = $base_url_non_masking."?api_key=".$api_key."&smsType=text&mobileNo=".$phone."&smsContent=".$message;

            $client = new Client();
            try {
                $request = $client->get($url);
//                logger($request);
            } catch (\Exception $exception) {
                logger($exception);
            }


            // sslwireless sms configuration

//            $user = config("message.sms_user");
//            $pass = config("message.sms_pass");
//            $sid = config("message.sms_sid");
//          $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
//          $response = $client->request('POST', $url, [
//                'form_params' => [
//                    'user' => $user,
//                    'pass' => $pass,
//                    'sid'  => $sid,
//                    'sms'  => [
//                        [$phone, $message],
//                    ],
//                ],
//            ]);

        }
    }
}

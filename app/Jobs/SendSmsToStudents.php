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

    protected $id;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $message)
    {
        $this->id = $id;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $student = User::with('studentInfo')->find($this->id);

        if (!$student) {

            logger('Student not found with id :' . $this->id);

            return;
        }

        if ($student['studentInfo']['is_sms_enabled'] == 1) {

            $phone = $student['studentInfo']['father_phone_number'];

            if (!empty($student['studentInfo']['guardian_phone_number'])) {

                $phone = $student['studentInfo']['guardian_phone_number'];
            }

            $phone_number = $this->numberCheck($phone);


            // datasoftbd sms

            $dataSoftSms = $this->dataSoftConfig($phone_number);


            // sslwireless sms

//            $sslWirlessSms = $this->sslWirelessConfig($phone_number, $message);


        }
    }

    /**
     * @param $phone
     * @return string
     */
    public function numberCheck($phone)
    {
        $checked_digit = substr($phone, 0, 3);

        if ($checked_digit == '+88') {
            $phone = ltrim($phone, '+');
        }

        $checked_zero = substr($phone, 0, 1);

        if ($checked_zero == 0) {
            $phone = '88' . $phone;
        }

        $checked_lastest = substr($phone, 0, 3);

        if ($checked_lastest !== '880') {
            $phone = ltrim($phone, '88');
            $phone = '880' . $phone;
        }

        return $phone;
    }

    /**
     * @param $phone
     * @param $message
     */
    public function sslWirelessConfig($phone, $message)
    {
        $user = config("message.sms_user");
        $pass = config("message.sms_pass");
        $sid = config("message.sms_sid");
        $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";

        $client = new Client();

        try {
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'user' => $user,
                    'pass' => $pass,
                    'sid' => $sid,
                    'sms' => [
                        [$phone, $message],
                    ],
                ],
            ]);

        } catch (\Exception $exception) {

            logger($exception);
        }

    }

    /**
     * @param $message
     * @param $phone_number
     */
    public function dataSoftConfig($phone_number)
    {
        $base_url_non_masking = config("message.sms_base_url");
        $api_key = config("message.sms_api_key");
        $message = urlencode($this->message);

        $url = $base_url_non_masking . "?api_key=" . $api_key . "&smsType=text&mobileNo=" . $phone_number . "&smsContent=" . $message;

        $client = new Client();

        try {
            $request = $client->get($url);

        } catch (\Exception $exception) {

            logger($exception);
        }
    }
}

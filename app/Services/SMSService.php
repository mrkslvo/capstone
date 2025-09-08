<?php

namespace App\Services;   // Make sure this file is in app/Services/

use Twilio\Rest\Client;

class SMSService
{
    protected $twilio;

    public function __construct()
    {
        $sid   = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->twilio = new Client($sid, $token);
    }

    public function sendSMS($to, $message)
    {
        // ✅ If number is PH (starts with 09…), convert to E.164
        if (preg_match('/^09\d{9}$/', $to)) {
            $to = '+63' . substr($to, 1);
        }

        return $this->twilio->messages->create(
            $to,
            [
                'from' => env('TWILIO_PHONE_NUMBER'), // Must match Twilio US number (+17175370237)
                'body' => $message,
            ]
        );
    }
}

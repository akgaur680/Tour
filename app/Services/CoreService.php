<?php

namespace App\Services;

use Exception;
use Twilio\Rest\Client;

class CoreService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }




    public function sendSMS($receiverNumber, $message)
    {
        try {
            $phone ="+91$receiverNumber";
            $sms = $this->twilio->messages->create(
                $phone,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => $message,
                ]
            );
            return  $sms;
            info('SMS Sent Successfully.');
        } catch (Exception $e) {

            info("Error: " . $e->getMessage());
        }
    }
}

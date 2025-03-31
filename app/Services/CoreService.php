<?php

namespace App\Services;

use App\Models\City;
use App\Models\State;
use Exception;
use Illuminate\Http\JsonResponse;
use Twilio\Rest\Client;

class CoreService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function jsonResponse(bool $status, string $message, $data = null): JsonResponse
    {
        return response()->json(compact('status', 'message', 'data'));
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

    public function extractLocationDetails($address): ?array
    {
        $parts = array_map('trim', explode(',', $address));
        return count($parts) < 2 ? null : [
            'city_id' => City::where('name', 'like', "%{$parts[0]}%")->value('id'),
            'state_id' => State::where('name', 'like', "%{$parts[1]}%")->value('id')
        ];
    }
}

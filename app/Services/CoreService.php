<?php

namespace App\Services;

use App\Models\City;
use App\Models\State;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
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
            $phone = "+91$receiverNumber";
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

    public function sendNotificationToCustomer($firebase_token, $title, $message)
    {
        $serviceAccountPath = public_path('json/google-services.json');
        $projectId = config('app.firebase.project_id');

        $payload = [
            'notification' => [
                'body' => $message,
                'title' => $title,
            ],
        ];

        try {
            $accessToken = $this->getAccessToken($serviceAccountPath);
            $payload['token'] = $firebase_token;
            $response = $this->sendMessage($accessToken, $projectId, $payload);
            return "DONE";
        } catch (Exception $e) {
           Log::error($e->getMessage(),'Error in sending notification');
        }
    }

    protected function getAccessToken($serviceAccountPath)
    {
        $client = new Client();
        $client->setAuthConfig($serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->useApplicationDefaultCredentials();
        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }

    protected function sendMessage($accessToken, $projectId, $message)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['message' => $message]));
        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true);
    }
}

<?php

namespace App\Services\Customer;

use Exception;
use Illuminate\Support\Facades\Http;

class CalculateDistanceService
{
    public function calculateDistance($origin, $destination)
    {
        try {
            $origin = $origin;
            $destination = $destination;
            $apiKey = env('GOOGLE_MAPS_API_KEY');

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins={$origin}&destinations={$destination}&key={$apiKey}";

            $response = Http::get($url);
            $data = $response->json();

            if (!empty($data['rows'][0]['elements'][0]['distance'])) {
                $distance = $data['rows'][0]['elements'][0]['distance']['text'];
                return $distance;
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to calculate distance'], 500);
        }
    }
}

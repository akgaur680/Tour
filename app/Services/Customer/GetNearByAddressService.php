<?php

namespace App\Services\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use App\Services\CoreService;


class GetNearByAddressService extends CoreService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_MAPS_API_KEY');
    }

    public function getCoordinates($city, $state): ?array
    {
        if (empty($city) || empty($state)) {
            return null;
        }

        $address = "{$city}, {$state}";
        $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $this->apiKey;

        $response = Http::get($geocodeUrl);

        if ($response->failed()) {
            return null;
        }

        $data = $response->json();

        return $data['results'][0]['geometry']['location'] ?? null;
    }

    public function getNearbyPlaces(Request $request): JsonResponse
    {
        $address = explode(',', $request->input('location', ''));

        if (count($address) < 2) {
            return response()->json(['status' => false,'message' => 'Invalid address format. Expected format: City, State'], 400);
        }

        $city = trim($address[0]);
        $state = trim($address[1]);
        $keyword = trim($request->query('query', ''));

        if (empty($keyword)) {
            return response()->json(['status' => false,'message' => 'Keyword is required'], 400);
        }

        $location = $this->getCoordinates($city, $state);

        if (!$location) {
            return response()->json(['status' => false,'message' => 'Invalid city or state'], 404);
        }

        $query = "{$keyword} in {$city}, {$state}";

        $placesUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . urlencode($query) . "&key=" . $this->apiKey;
        $response = Http::get($placesUrl);

        if ($response->failed()) {
            return response()->json(['status' => false,'message' => 'Failed to fetch nearby places'], 500);
        }

        $places = $response->json();

        $filteredPlaces = collect($places['results'])
        ->map(fn($place) => $place['name'] . ', ' . $city . ', ' . $state)
        ->values();

        return $this->jsonResponse(true,'Nearby places found',$filteredPlaces);
    }

    public function getPickupAddresses(Request $request): JsonResponse
    {
        return $this->getNearbyPlaces($request);
    }
}

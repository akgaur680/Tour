<?php

namespace App\Services\Customer;

use App\Models\Car;
use App\Models\City;
use App\Models\FixedTourPrices;
use App\Models\State;
use Illuminate\Http\JsonResponse;

class TripCostEstimatorService
{
    public function calculateFarePrice($request): JsonResponse
    {
        $fixedPriceResponse = $this->isFixedPriceAvailable($request);
        return $fixedPriceResponse ?? $this->calculatePriceOnDistance($request);
    }

    private function isFixedPriceAvailable($request): ?JsonResponse
    {
        $from = $this->extractLocationDetails($request->from_address);
        $to = $this->extractLocationDetails($request->to_address);

        if (!$from || !$to) {
            return $this->jsonResponse(false, 'Invalid city or state name in the provided addresses.');
        }

        $fixedPrice = FixedTourPrices::where([
            ['origin_city_id', $from['city_id']],
            ['origin_state_id', $from['state_id']],
            ['destination_city_id', $to['city_id']],
            ['destination_state_id', $to['state_id']]
        ])->with('car')->get();

        if ($fixedPrice->isNotEmpty()) {
            return $this->jsonResponse(true, 'Fixed price found for this route.', $this->formatCarData($fixedPrice));
        }

        return null;
    }

    private function formatCarData($cars)
    {
        return $cars->map(function ($item) {
            return [
                'car_id' => $item->car->id,
                'car_name' => $item->car->car_model,
                'car_number' => $item->car->car_number,
                'car_type' => $item->car->car_type,
                'seats' => $item->car->seats,
                'is_ac' => $item->car->ac ? 'Yes' : 'No',
                'luggage_limit' => $item->car->luggage_limit,
                'price_per_km' => $item->car->price_per_km,
                'car_image' => url('public/' . ltrim($item->car->car_image, '/')),
                'price' => $item->price
            ];
        });
    }

    private function extractLocationDetails($address): ?array
    {
        $parts = array_map('trim', explode(',', $address));
        return count($parts) < 2 ? null : [
            'city_id' => $this->getCityId($parts[0]),
            'state_id' => $this->getStateId($parts[1])
        ];
    }

    private function getCityId($cityName): ?int
    {
        return City::where('name', 'like', '%' . $cityName . '%')->value('id');
    }

    private function getStateId($stateName): ?int
    {
        return State::where('name', 'like', '%' . $stateName . '%')->value('id');
    }

    private function jsonResponse(bool $status, string $message, $data = null): JsonResponse
    {
        return response()->json(compact('status', 'message', 'data'));
    }

    public function calculatePriceOnDistance($request): JsonResponse
    {
        if (empty($request->from_address) || empty($request->to_address)) {
            return $this->jsonResponse(false, 'Both from and to addresses are required.');
        }

        $distance = $this->getDistanceBetweenLocations($request->from_address, $request->to_address);

        if ($distance <= 0) {
            return $this->jsonResponse(false, 'Invalid distance or duration received.');
        }

        $cars = $this->getAllCars();
        if ($cars->isEmpty()) {
            return $this->jsonResponse(false, 'No cars available.');
        }

        return $this->jsonResponse(true, 'Price Found for this route.', $this->calculateCarPrices($cars, $distance));
    }

    private function getDistanceBetweenLocations($fromAddress, $toAddress): int
    {
        $from = $this->formatLocation($fromAddress);
        $to = $this->formatLocation($toAddress);

        $distanceService = new CalculateDistanceService();
        $distance = $distanceService->calculateDistance($from, $to);
        
        return (int) str_replace([',', 'Km', 'KM'], '', trim($distance));
    }

    private function formatLocation($address): string
    {
        $parts = array_map('trim', explode(',', $address));
        $city = City::where('name', 'like', '%' . $parts[0] . '%')->value('name');
        $state = State::where('name', 'like', '%' . $parts[1] . '%')->value('name');
        return "$city, $state";
    }

    private function calculateCarPrices($cars, $distance)
    {
        return $cars->map(function ($car) use ($distance) {
            return [
                'car_id' => $car->id,
                'car_name' => $car->car_model,
                'car_number' => $car->car_number,
                'car_type' => $car->car_type,
                'seats' => $car->seats,
                'is_ac' => $car->ac ? 'Yes' : 'No',
                'luggage_limit' => $car->luggage_limit,
                'price_per_km' => $car->price_per_km,
                'car_image' => url('public/' . ltrim($car->car_image, '/')),
                'price' => $car->price_per_km * $distance,
                'total_distance' => $distance . ' Km',
            ];
        });
    }

    private function getAllCars()
    {
        return Car::all();
    }
}

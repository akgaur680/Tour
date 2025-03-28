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
        return $this->isFixedPriceAvailable($request) ?? $this->calculatePriceOnDistance($request);
    }

    private function isFixedPriceAvailable($request): ?JsonResponse
    {
        $from = $this->extractLocationDetails($request->from_address);
        $to = $this->extractLocationDetails($request->to_address);
        $distance = $this->getDistanceBetweenLocations($request->from_address, $request->to_address);

        if (!$from || !$to) {
            return $this->jsonResponse(false, 'Invalid city or state name in the provided addresses.');
        }

        $fixedPrices = FixedTourPrices::where([
            ['origin_city_id', $from['city_id']],
            ['origin_state_id', $from['state_id']],
            ['destination_city_id', $to['city_id']],
            ['destination_state_id', $to['state_id']]
        ])->with('car')->get();

        return $fixedPrices->isEmpty() ? null : 
            $this->jsonResponse(true, 'Fixed price found for this route.', $this->formatCarData($fixedPrices, $request, $distance));
    }

    private function formatCarData($cars, $request, $distance)
    {
        return $cars->map(fn($item) => array_merge($this->getCarDetails($item->car), [
            'price' => $item->price,
            'customer_name' => $request->user()->name,
            'customer_phone' => $request->user()->mobile_no,
            'customer_email' => $request->user()->email,
            'total_distance' => "$distance Km",
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'return_date' => $request->return_date ? $request->return_date : null,
            'inclusions' => $this->getInclusions($request->trip_type, $item->car->price_per_km, $distance),
            'exclusions' => $this->getExclusions($request->trip_type, $item->car->price_per_km, $distance),
        ]));
    }

    private function getCarDetails($car)
    {
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
        ];
    }

    private function extractLocationDetails($address): ?array
    {
        $parts = array_map('trim', explode(',', $address));
        return count($parts) < 2 ? null : [
            'city_id' => City::where('name', 'like', "%{$parts[0]}%")->value('id'),
            'state_id' => State::where('name', 'like', "%{$parts[1]}%")->value('id')
        ];
    }

    private function jsonResponse(bool $status, string $message, $data = null): JsonResponse
    {
        return response()->json(compact('status', 'message', 'data'));
    }

    public function calculatePriceOnDistance($request): JsonResponse
    {
        $distance = $this->getDistanceBetweenLocations($request->from_address, $request->to_address);
        if ($distance <= 0) {
            return $this->jsonResponse(false, 'Invalid distance or duration received.');
        }

        $cars = Car::all();
        return $cars->isEmpty() ? $this->jsonResponse(false, 'No cars available.') :
            $this->jsonResponse(true, 'Price found for this route.', $this->calculateCarPrices($cars, $distance, $request));
    }

    private function getDistanceBetweenLocations($fromAddress, $toAddress): int
    {
        return (int) preg_replace('/[^0-9]/', '', (new CalculateDistanceService())->calculateDistance($fromAddress, $toAddress));
    }

    private function calculateCarPrices($cars, $distance, $request)
    {
        return $cars->map(fn($car) => array_merge($this->getCarDetails($car), [
            'customer_name' => $request->user()->name,
            'customer_phone' => $request->user()->mobile_no,
            'customer_email' => $request->user()->email,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'return_date' => $request->return_date ? $request->return_date : null,
            'price' => $car->price_per_km * $distance,
            'total_distance' => "$distance Km",
            'inclusions' => $this->getInclusions($request->trip_type, $car->price_per_km, $distance),
            'exclusions' => $this->getExclusions($request->trip_type, $car->price_per_km, $distance),
        ]));
    }

    private function getInclusions($tripType, $carPricePerKm, $distance)
    {
        return $tripType === 'one-way' ?
            ['Fuel Charges', 'Driver Allowance', 'Toll / State Tax (₹680 - ₹810)', 'GST 5%'] :
            ["Pay ₹{$carPricePerKm}/km after {$distance} Km", 'Fuel Charges', 'Driver Allowance', 'GST 5%'];
    }

    private function getExclusions($tripType, $carPricePerKm, $distance)
    {
        return $tripType === 'one-way' ?
            ["Pay ₹{$carPricePerKm}/km after {$distance} Km", 'Multiple pickups/drops', 'Airport Entry/Parking'] :
            ['Toll / State Tax (₹680 - ₹810)', 'Night Allowance', 'Parking'];
    }
}
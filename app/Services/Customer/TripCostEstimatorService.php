<?php

namespace App\Services\Customer;

use App\Models\Airport;
use App\Models\Car;
use App\Models\CarTripType;
use App\Models\City;
use App\Models\Driver;
use App\Models\FixedTourPrices;
use App\Models\State;
use App\Models\TripType;
use App\Services\CoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class TripCostEstimatorService extends CoreService
{
    public function calculateFarePrice($request): JsonResponse
    {
        return match ($request->trip_type) {
            'one-way' => $this->isFixedPriceAvailable($request),
            'local' => $this->calculatePriceOnHours($request),
            // 'airport' => $this->calculatePriceOnAirportDistance($request),
            'airport' => $this->isFixedPriceAvailable($request),
            default => $this->calculatePriceOnDistance($request),
        };
    }

    private function calculatePriceOnAirportDistance($request): JsonResponse
    {
        $distance = $this->getDistanceBetweenLocations($request->airport_location, $request->to_address);
        if ($distance <= 0) {
            return $this->jsonResponse(false, 'Invalid distance or duration received.');
        }

        $cars = $this->getCarsForTrip($request->trip_type);
        return $cars->isEmpty()
            ? $this->jsonResponse(false, 'No cars available.')
            : $this->jsonResponse(true, 'Price found for this route.', $this->calculateCarPrices($cars, $distance, $request));
    }

    private function calculatePriceOnHours($request): JsonResponse
    {
        $cars = $this->getCarsForTrip($request->trip_type);
        return $cars->isEmpty()
            ? $this->jsonResponse(false, 'No cars available.')
            : $this->jsonResponse(true, 'Price found for this route.', $this->calculateCarPricesForLocal($cars, $request));
    }

    private function calculateCarPricesForLocal($cars, $request): array
    {
        return $cars->map(fn($car) => array_merge($this->getCarDetails($car), [
            'customer_details' => $this->getCustomerDetails($request),
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'price' => "₹" . $car->price_per_hour * $request->total_hours,
            'total_distance' => $request->total_hours * 10 . " Km",
            'total_hours' => $request->total_hours . " Hours",
            'inclusions' => $this->getInclusions($request->trip_type, $car->price_per_km, $request->total_hours * 10),
            'exclusions' => $this->getExclusions($request->trip_type, $car->price_per_km, $request->total_hours * 10, $car->price_per_hour),
            'pickup_city' => $request->from_address ? explode(',', $request->from_address)[0] : null,
            'pickup_state' => $request->from_address ? explode(',', $request->from_address)[1] : null,
            'drop_city' => $request->to_address ? explode(',', $request->to_address)[0] : null,
            'drop_state' => $request->to_address ? explode(',', $request->to_address)[1] : null,
                'trip_type' => match ($request->trip_type) {
                    'airport' => 'Outstation | One Way',
                    'local' => 'Local ' . $car->price_per_hour . ' hrs | ' . ($car->price_per_hour * 10) . ' kms : One Way',
                    default => 'Outstation | Round Trip',
                },
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'return_date' => $request->return_date ? $request->return_date : null,
                'airport_location' => $request->trip_type == 'airport' ? $request->airport_location : null,
        ]))->toArray();
    }

    private function isFixedPriceAvailable($request): ?JsonResponse
    {
        $getTripTypeId = TripType::where('slug', $request->trip_type)->value('id');

        if ($request->trip_type == 'airport') {
            return $this->checkFixedPriceForAirport($request, $getTripTypeId);
        }

        if (!$getTripTypeId) {
            return $this->jsonResponse(false, 'Invalid trip type.');
        }
        $from = $this->extractLocationDetails($request->from_address);
        $to = $this->extractLocationDetails($request->to_address);
        if (!$from || !$to) {
            return $this->jsonResponse(false, 'Invalid city or state name in the provided addresses.');
        }

        $fixedPrices = FixedTourPrices::where([
            ['origin_city_id', $from['city_id']],
            ['origin_state_id', $from['state_id']],
            ['destination_city_id', $to['city_id']],
            ['destination_state_id', $to['state_id']],
            ['trip_type_id', $getTripTypeId],
        ])->with('car')->get();

        return $fixedPrices->isEmpty() ? $this->jsonResponse(true, 'No Cars - no car available in the given city') :
            $this->jsonResponse(true, 'Fixed price found for this route.', $this->formatCarData($fixedPrices, $request));
    }

    private function formatCarData($cars, $request)
    {
        $distance = $this->getDistanceBetweenLocations($request->from_address, $request->to_address);

        return $cars->map(function ($item) use ($request, $distance) {
            $data = array_merge($this->getCarDetails($item->car), [
                'customer_details' => $this->getCustomerDetails($request),
                'price' => "₹" . ($request->trip_type == 'round-trip' ? $item->price * 2 : $item->price),
                'total_distance' => $request->trip_type == 'round-trip' ? ($distance * 2) . " Km" : "$distance Km",
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'inclusions' => $this->getInclusions($request->trip_type, $item->car->price_per_km, $distance),
                'exclusions' => $this->getExclusions($request->trip_type, $item->car->price_per_km, $distance),
                'pickup_city' => $request->from_address ? explode(',', $request->from_address)[0] : null,
                'pickup_state' => $request->from_address ? explode(',', $request->from_address)[1] : null,
                'drop_city' => $request->to_address ? explode(',', $request->to_address)[0] : null,
                'drop_state' => $request->to_address ? explode(',', $request->to_address)[1] : null,
                'trip_type' => match ($request->trip_type) {
                    'airport' => 'Outstation | One Way',
                    'local' => 'Local ' . $item->car->price_per_hour . ' hrs | ' . ($item->car->price_per_hour * 10) . ' kms : One Way',
                    default => 'Outstation | Round Trip',
                },
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'return_date' => $request->return_date ? $request->return_date : null,
                'airport_location' => $request->trip_type == 'airport' ? $request->airport_location : null,
            ]);
            return $data;
        })->toArray();
    }


    private function calculatePriceOnDistance($request): JsonResponse
    {
        $distance = $this->getDistanceBetweenLocations($request->from_address, $request->to_address);
        if ($distance <= 0) {
            return $this->jsonResponse(false, 'Invalid distance or duration received.');
        }

        $cars = $this->getCarsForTrip($request->trip_type);
        return $cars->isEmpty() ? $this->jsonResponse(false, 'No cars available.') :
            $this->jsonResponse(true, 'Price found for this route.', $this->calculateCarPrices($cars, $distance, $request));
    }

    private function calculateCarPrices($cars, $distance, $request): array
    {
        return $cars->map(function ($car) use ($request, $distance) {
            $data = array_merge($this->getCarDetails($car), [
                'customer_details' => $this->getCustomerDetails($request),
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'price' => "₹" . ($request->trip_type == 'round-trip'
                    ? $car->price_per_km * ($distance * 2)
                    : $car->price_per_km * $distance),
                'total_distance' => $request->trip_type == 'round-trip'
                    ? ($distance * 2) . " Km"
                    : "$distance Km",
                'inclusions' => $this->getInclusions($request->trip_type, $car->price_per_km, $distance),
                'exclusions' => $this->getExclusions($request->trip_type, $car->price_per_km, $distance),
                'pickup_city' => $request->from_address ? explode(',', $request->from_address)[0] : null,
                'pickup_state' => $request->from_address ? explode(',', $request->from_address)[1] : null,
                'drop_city' => $request->to_address ? explode(',', $request->to_address)[0] : null,
                'drop_state' => $request->to_address ? explode(',', $request->to_address)[1] : null,
                'trip_type' => match ($request->trip_type) {
                    'airport' => 'Outstation | One Way',
                    'local' => 'Local ' . $car->price_per_hour . ' hrs | ' . ($car->price_per_hour * 10) . ' kms : One Way',
                    default => 'Outstation | Round Trip',
                },
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'return_date' => $request->return_date ? $request->return_date : null,
                'airport_location' => $request->trip_type == 'airport' ? $request->airport_location : null,
            ]);

            if (!is_null($request->return_date)) {
                $data['return_date'] = $request->return_date;
            }

            if ($request->trip_type == 'airport') {
                $data['airport_location'] = $request->airport_location;
            }

            return $data;
        })->toArray();
    }


    private function getCarDetails($car): array
    {
        return array_merge([
            'car_id' => $car->id,
            'car_name' => $car->car_type,
            'car_number' => $car->car_number,
            'car_model' => $car->car_model,
            'seats' => $car->seats,
            'is_ac' => $car->ac ? 'Yes' : 'No',
            'luggage_limit' => $car->luggage_limit,
            'price_per_km' => $car->price_per_km,
            'price_per_hour' => $car->price_per_hour,
            'car_image' => url('public/' . ltrim($car->car_image, '/')),
        ],$this->getDriverDetails($car));
    }

    private function getDriverDetails($car): array
    {
        $checkCarHasDriver = Driver::where('car_id', $car->id)->exists();
        if (!$checkCarHasDriver) {
            return [
                'driver_id' => null,
                'driver_name' => null,
                'driver_phone' => null,
                'driver_email' => null,
                'is_driver_verified' => false,
                'is_driver_available' => false
            ];
        }
        else{
            $driver = Driver::where('car_id', $car->id)->with('user')->first();
            return [
                'driver_id' => $driver->user->id,
                'driver_name' => $driver->user->name,
                'driver_phone' => $driver->user->mobile_no,
                'driver_email' => $driver->user->email,
                'is_driver_verified' => $driver->is_approved,
                'is_driver_available' => $driver->is_available
            ];
        }
    }

    private function getCustomerDetails($request): array
    {
        return [
            'name' => $request->user()->name,
            'phone' => $request->user()->mobile_no,
            'email' => $request->user()->email,
        ];
    }

    private function getInclusions($tripType, $carPricePerKm, $distance): array
    {
        return match ($tripType) {
            'one-way' => ['Fuel Charges', 'Driver Allowance', 'Toll / State Tax (₹680 - ₹810)', 'GST 5%'],
            'local' => ['Fuel Charges', 'Driver Allowance', 'GST 5%'],
            'airport' => ['Fuel Charges', 'Driver Allowance', 'Night Allowance', 'Airport Parking', 'Toll / State Tax (₹680 - ₹810)', 'GST 5%'],
            default => ["Pay ₹{$carPricePerKm}/km after {$distance} Km", 'Fuel Charges', 'Driver Allowance', 'GST 5%']
        };
    }

    private function getExclusions($tripType, $carPricePerKm, $distance, $carPricePerHour = null): array
    {
        return match ($tripType) {
            'one-way' => ["Pay ₹{$carPricePerKm}/km after {$distance} Km", 'Multiple pickups/drops', 'Airport Entry/Parking'],
            'local' => [
                "Pay ₹{$carPricePerKm}/km after {$distance} Km",
                "Pay ₹{$carPricePerHour}/hour after " . ceil($distance / 10) . " Hours",
                'Toll / State Tax (₹680 - ₹810)',
                'Night Allowance',
                'Parking'
            ],
            'airport' => ["Pay ₹{$carPricePerKm}/km after {$distance} Km", 'Airport Entry/ Parking', 'Multiple Pickups'],
            default => ['Toll / State Tax (₹680 - ₹810)', 'Night Allowance', 'Parking'],
        };
    }


    private function getDistanceBetweenLocations($fromAddress, $toAddress): int
    {
        return (int) preg_replace('/[^0-9]/', '', (new CalculateDistanceService())->calculateDistance($fromAddress, $toAddress));
    }

    private function getCarsForTrip(string $tripType): Collection
    {
        $getTripId = TripType::where('slug', $tripType)->value('id');

        if (!$getTripId) {
            return collect();
        }

        $getTripTypeCarsIds = CarTripType::where('trip_type_id', $getTripId)->pluck('car_id');
        
        if ($getTripTypeCarsIds->isEmpty()) {
            return collect();
        }
       
        return Car::whereIn('id', $getTripTypeCarsIds)->get();
    }

    private function checkFixedPriceForAirport($request, $getTripTypeId)
    {

        $airportName = strtok($request->airport_location, ',');
        $getAirpotId = Airport::where('name', $airportName)->value('id');
        
        if (!$getAirpotId) {
            return $this->jsonResponse(false, 'Invalid airport name.');
        }
    
        if ($request->from_airport) {   
            $to = $this->extractLocationDetails($request->to_address);
    
            if (!$to) {
                return $this->jsonResponse(false, 'Invalid city or state name in the provided addresses.');
            }
    
            $fixedPrices = FixedTourPrices::where([
                ['destination_city_id', $to['city_id']],
                ['destination_state_id', $to['state_id']],
                ['trip_type_id', $getTripTypeId],
                ['airport_id', $getAirpotId],
            ])->with('car')->get();
            
        } else {

            $from = $this->extractLocationDetails($request->from_address);
            if (!$from) {
                return $this->jsonResponse(false, 'Invalid city or state name in the provided addresses.');
            }
            $fixedPrices = FixedTourPrices::where([
                ['airport_id', $getAirpotId],
                ['destination_city_id', $from['city_id']],
                ['destination_state_id', $from['state_id']],
                ['trip_type_id', $getTripTypeId],
                ['airport_id', $getAirpotId],
            ])->with('car')->get();
        }

        if ($fixedPrices->isEmpty()) {
            return  $this->jsonResponse(true, 'No Cars - no car available in the given city');
        }
        
        return $this->jsonResponse(true, 'Fixed price found for this route.', $this->formatCarData($fixedPrices, $request));
    }
    
}

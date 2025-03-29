<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\BookATripRequest;
use App\Http\Requests\Api\Customer\GetAddressRequest;
use App\Http\Requests\Api\Customer\TripCostEstimateRequest;
use App\Services\Customer\BookATripService;
use App\Services\Customer\GetAirportService;
use App\Services\Customer\GetCityStateService;
use App\Services\Customer\GetNearByAddressService;
use App\Services\Customer\TripCostEstimatorService;
use Illuminate\Http\Request;

class RideBookingController extends Controller
{
    public function getEstimateTripCost(TripCostEstimateRequest $request)
    {
      return (new TripCostEstimatorService())->calculateFarePrice($request);  
    }

    public function getNearbyPlaces(GetAddressRequest $request)
    {
      return (new GetNearByAddressService())->getNearbyPlaces($request);
    }

    public function getCityState(Request $request)
    {
        return (new GetCityStateService())->getPlaces($request);
    }

    public function getAirports(Request $request)
    {
        return (new GetAirportService())->getAirports($request);
    }

    public function bookATrip(BookATripRequest $request){
      return (new BookATripService())->bookATrip(request());
    }
}

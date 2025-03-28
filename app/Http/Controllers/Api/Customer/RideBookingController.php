<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\TripCostEstimateRequest;
use App\Services\Customer\GetCityStateService;
use App\Services\Customer\TripCostEstimatorService;
use Illuminate\Http\Request;

class RideBookingController extends Controller
{
    public function getEstimateTripCost(TripCostEstimateRequest $request)
    {
      return (new TripCostEstimatorService())->calculateFarePrice($request);  
    }

    public function getPlaces(){

    }

    public function getCityState(Request $request)
    {
        return (new GetCityStateService())->getPlaces($request);
    }
}

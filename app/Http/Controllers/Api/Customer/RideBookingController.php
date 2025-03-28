<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\Api\Customer\TripCostEstimateRequest;
<<<<<<< Updated upstream
=======
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
=======
use App\Services\Customer\CalculateDistanceService;
use App\Services\Customer\TripCostEstimatorService;
>>>>>>> Stashed changes
use Illuminate\Http\Request;

class RideBookingController extends Controller
{
<<<<<<< HEAD
    public function getOneWayAndRoundTripFare(TripCostEstimateRequest $request)
    {
        $getDistance = (new CalculateDistanceService)->calculateDistance($request->from_address, $request->to_address);
        return response([
            'status' => true,
            'message' => 'Distance calculated successfully',
            'data' => [
                'distance' => $getDistance,
            ],
        ]); 
    }
=======

>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
}

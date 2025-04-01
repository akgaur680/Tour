<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\BookATripRequest;
use App\Http\Requests\Api\Customer\CancelTripRequest;
use App\Http\Requests\Api\Customer\PaymentProofRequest;
use App\Services\Customer\BookATripService;
use App\Services\Customer\CancelATripService;
use App\Services\Customer\GetAllBookedTripsService;
use App\Services\Customer\UploadPaymentProofService;
use Illuminate\Http\Request;

class TripBookingController extends Controller
{
    public function bookATrip(BookATripRequest $request)
    {
      return (new BookATripService())->bookATrip($request); 
    }

    public function uploadPaymentProof(PaymentProofRequest $request)
    {
      return (new UploadPaymentProofService())->uploadPaymentProof($request);
    }

    // On Hold
    public function getBookedTrips(Request $request)
    {
      return (new GetAllBookedTripsService())->getAllBookedTrips($request);
    }

    public function cancelATrip(CancelTripRequest $request)
    {
      return (new CancelATripService())->cancelATrip($request);
    }
}



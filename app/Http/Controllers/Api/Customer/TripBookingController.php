<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\BookATripRequest;
use App\Services\Customer\BookATripService;
use Illuminate\Http\Request;

class TripBookingController extends Controller
{
    public function bookATrip(BookATripRequest $request)
    {
      return (new BookATripService())->bookATrip(request());
    }
}

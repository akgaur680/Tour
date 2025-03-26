<?php

use App\Http\Controllers\Api\Customer\RideBookingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api'])->group(function () {
    
    Route::post('/cost/oneway-roundtrip',[RideBookingController::class,'getOneWayAndRoundTripFare']);
    
});
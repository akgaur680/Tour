<?php

use App\Http\Controllers\Api\Customer\RideBookingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api'])->group(function () {
    
    Route::get('/get-trip-cost',[RideBookingController::class,'getOneWayTripCost'] );
    
});
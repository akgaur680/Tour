<?php

use App\Http\Controllers\Api\Customer\RideBookingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api'])->group(function () {
    
    Route::get('/get-trip-cost',[RideBookingController::class,'getEstimateTripCost'] );

    Route::get('/get-places',[RideBookingController::class,'getPlaces'] );

    Route::get('/get-city-state/{query}',[RideBookingController::class,'getCityState']);
    
});
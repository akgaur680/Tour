<?php

use App\Http\Controllers\Api\Customer\RideBookingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api'])->group(function () {
    
    Route::get('/get-trip-cost',[RideBookingController::class,'getEstimateTripCost'] );
    Route::get('/get-city-state',[RideBookingController::class,'getCityState']);
    Route::get('/get-nearby-places',[RideBookingController::class,'getNearbyPlaces'] );
    Route::get('/get-airports',[RideBookingController::class,'getAirports'] );
    Route::get('/book-a-trip',[RideBookingController::class,'bookATrip'] );

    
    
});

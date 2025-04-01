<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Customer\RideBookingController;
use App\Http\Controllers\Api\Customer\TripBookingController;
use Illuminate\Support\Facades\Route;


Route::get('/get-city-state',[RideBookingController::class,'getCityState']);
Route::get('/get-airports',[RideBookingController::class,'getAirports'] );
Route::middleware(['auth:api'])->group(function () {
    
    // Get Estimate Trip Cost
    Route::post('/get-trip-cost',[RideBookingController::class,'getEstimateTripCost'] );

    // Get City State

    // Get Nearby Places
    Route::get('/get-nearby-places',[RideBookingController::class,'getNearbyPlaces'] );

    // Get Airports

    // Update Profile
    Route::post('/update-profile',[AuthController::class,'updateProfile'] );

    // Book A Trip
    Route::post('/book-a-trip',[TripBookingController::class,'bookATrip'] );

    // Cancel A Trip
    Route::post('/cancel-a-trip',[TripBookingController::class,'cancelATrip'] );

    // Get Booked Trips
    Route::get('/get-booked-trips',[TripBookingController::class,'getBookedTrips'] );

    // Get Profile Details
    Route::get('get-profile-details',[AuthController::class,'getProfileDetails'] );
    
    // Upload Payment Proof
    Route::post('/upload-payment-proof',[TripBookingController::class,'uploadPaymentProof'] );
});


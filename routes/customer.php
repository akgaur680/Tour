<?php

<<<<<<< HEAD
use App\Http\Controllers\Api\Customer\RideBookingController;
=======
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api'])->group(function () {
    
<<<<<<< HEAD
    Route::post('/cost/oneway-roundtrip',[RideBookingController::class,'getOneWayAndRoundTripFare']);
=======
    Route::get('/one-way-trip', );
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
    
});
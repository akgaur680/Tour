<?php

use App\Http\Controllers\Api\Driver\AuthDriverController;
use Illuminate\Support\Facades\Route;

// Register Driver
Route::post('/register-driver', [AuthDriverController::class, 'registerDriver']);

Route::middleware(['auth:api'])->group(function () {

});
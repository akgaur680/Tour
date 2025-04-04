<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Bookings\BookingController;
use App\Http\Controllers\Web\Cars\CarController;
use App\Http\Controllers\Web\Customers\CustomerController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Drivers\DriverController;
use App\Http\Controllers\Web\FixedPricing\FixedPricingController;
use App\Http\Controllers\Web\TripType\TripTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CitiesImport;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::get('/', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', function () {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(), // Get assigned roles
        ]);
    });

    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // CARS AREA

    Route::resource('/admin/cars', CarController::class);
    Route::resource('admin/drivers', DriverController::class);
    Route::resource('admin/fixed-pricing', FixedPricingController::class);
    Route::resource('/admin/trip-type', TripTypeController::class);
    Route::resource('/admin/customers', CustomerController::class);

    Route::get('/admin/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::delete('/admin/cancel-booking/{token}', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');
});
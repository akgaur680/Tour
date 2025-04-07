<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Bookings\BookingController;
use App\Http\Controllers\Web\Cars\CarController;
use App\Http\Controllers\Web\Customers\CustomerController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DriverRequest\DriverRequestController;
use App\Http\Controllers\Web\Drivers\DriverController;
use App\Http\Controllers\Web\FixedPricing\FixedPricingController;
use App\Http\Controllers\Web\FixedPricing\GetCityStateController;
use App\Http\Controllers\Web\Locations\GetPlacesController;
use App\Http\Controllers\Web\TripType\TripTypeController;
use App\Http\Controllers\Web\Transaction\TransactionController;
use App\Http\Controllers\Web\VerifyPayment\VerifyPaymentController;
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
    Route::post('/admin/drivers/{id}/toggle-availability', [DriverController::class, 'toggleAvailability']);
    Route::post('/admin/drivers/{id}/toggle-approval', [DriverController::class, 'toggleApproval']);

    Route::resource('admin/fixed-pricing', FixedPricingController::class);
    Route::get('/admin/get-city-state', [GetPlacesController::class, 'getPlaces']);
    Route::get('/admin/get-airports', [GetPlacesController::class, 'getAirpots']);
    Route::resource('/admin/trip-type', TripTypeController::class);
    Route::resource('/admin/customers', CustomerController::class);

    Route::get('/admin/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::delete('/admin/cancel-booking/{token}', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');

    Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/admin/transactions/{id}', [TransactionController::class, 'getTransactionDetails'])->name('transactions.details');

    Route::get('/admin/verify-payments', [VerifyPaymentController::class, 'index'])->name('verify-payments.index');
    Route::get('/admin/verify-payment/{id}', [VerifyPaymentController::class, 'getVerifyPaymentDetails'])->name('verify-payments.details');
    Route::post('/admin/verify-payment/{id}', [VerifyPaymentController::class, 'updateVerifyPaymentStatus'])->name('verify-payments.update-status');

    Route::get('/admin/driver-requests', [DriverRequestController::class, 'index'])->name('driver-requests.index');
    Route::get('admin/driver-request/{id}', [DriverRequestController::class, 'getDriverRequestDetails'])->name('driver-requests.details');
    Route::post('/admin/driver-request/{id}', [DriverRequestController::class, 'submitApprovalStatus'])->name('driver-requests.update-status');
});

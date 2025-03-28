<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Cars\CarController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

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
});
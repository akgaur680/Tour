<?php

use App\Http\Controllers\Web\Auth\AuthController;
<<<<<<< HEAD
=======
use App\Http\Controllers\Web\Cars\CarController;
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

<<<<<<< HEAD
Route::get('/', [AuthController::class, 'showlogin']);
=======
// Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::get('/', [AuthController::class, 'showlogin'])->name('login');
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', function () {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(), // Get assigned roles
        ]);
    });

<<<<<<< HEAD
    Route::get('/dashboard/admin/index', [DashboardController::class, 'index']);
=======
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // CARS AREA

    Route::resource('/admin/cars', CarController::class);
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
});
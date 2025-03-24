<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'showlogin']);
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', function () {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(), // Get assigned roles
        ]);
    });

    Route::get('/dashboard/admin/index', [DashboardController::class, 'index']);
});
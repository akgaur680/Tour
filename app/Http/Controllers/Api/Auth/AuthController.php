<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\VerifyOtpRequest;
use App\Services\Auth\AuthByMobile;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        return (new AuthByMobile)->register($request->validated());
    }

    public function login(LoginRequest $request)
    {
        return (new AuthByMobile)->login($request->validated());
    }

    public function otpVerify(VerifyOtpRequest $request)
    {
        return (new AuthByMobile)->otpVerify($request->validated());
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $request->user()->token()->revoke(); // Revoke the token
            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }


    public function logoutFromAllDevices(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $user->tokens()->delete(); // Revoke all tokens
            return response()->json(['message' => 'Logged out from all devices']);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }
}

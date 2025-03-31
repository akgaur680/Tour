<?php

namespace App\Services\Auth;

use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetProfileDetailsService
{
    public function getProfileDetails(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return $this->jsonResponse(false, 'User not found.');
        }

        if ($user->role === 'customer') {
            return $this->jsonResponse(true, 'Profile found of customer.', $this->formatData($user));
        }

        $driver = Driver::where('user_id', $user->id)->with('user')->first();

        if (!$driver) {
            return $this->jsonResponse(false, 'Driver profile not found.');
        }

        return $this->jsonResponse(true, 'Profile found of driver.', $this->formatData($driver->user ?? $user));
    }

    private function formatData($user): array
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->mobile_no ?? null,
            'role' => $user->role,
        ];
    }

    private function jsonResponse(bool $status, string $message, $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
}

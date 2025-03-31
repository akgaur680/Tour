<?php

namespace App\Services\Customer;

use Illuminate\Http\JsonResponse;

class UpdateCustomerProfile {
    public function updateProfile($request) : JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return $this->jsonResponse(false, 'User not found.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return $this->jsonResponse(true, 'Profile updated successfully.', $user);
    }

    private function jsonResponse(bool $status, string $message, $data = null): JsonResponse
    {
        return response()->json(compact('status', 'message', 'data'));
    }
}
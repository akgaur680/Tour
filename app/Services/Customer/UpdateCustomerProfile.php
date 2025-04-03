<?php

namespace App\Services\Customer;

use App\Services\CoreService;
use Illuminate\Http\JsonResponse;

class UpdateCustomerProfile extends CoreService{
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

}
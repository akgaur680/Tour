<?php

namespace App\Services\Customer;

use App\Models\Order;
use App\Services\CoreService;

class CancelATripService extends CoreService
{
    public function cancelATrip($request)
    {
        $trip = Order::where(['booking_token' => $request->booking_token , 'user_id' => $request->user()->id])->first();
        $trip->booking_status = 'cancelled';
        $trip->save();

        if ($trip) {
            return $this->jsonResponse(true, 'Trip Cancelled Successfully');
        }
        else{
            return $this->jsonResponse(false, 'Trip not found');
        }
    }
}
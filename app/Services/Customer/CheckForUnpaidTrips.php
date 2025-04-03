<?php

namespace App\Services\Customer;

use App\Models\Order;
use App\Services\CoreService;

class CheckForUnpaidTrips extends CoreService
{
    public function checkForUnpaidTrips($request)
    {
        $user = $request->user();

        $unpaidTrips = Order::where('user_id', $user->id)
            ->where('payment_status', 'pending')
            ->where('booking_status', '!=', 'cancelled')
            ->whereDate('pickup_date', '<=' , now()->toDateString())
            ->get();

        if ($unpaidTrips->count() > 0) {
            return $this->jsonResponse(true, "Unpaid trips found", [
                'totalUnpaidTrips' => $unpaidTrips->count(),
                'data' => $unpaidTrips
            ]);
        }

        return $this->jsonResponse(false, "No unpaid trips found");
    }
}

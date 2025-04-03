<?php

namespace App\Services\Customer;

use App\Models\Order;
use App\Services\CoreService;

class GetAllBookedTripsService extends CoreService
{
    public function getAllBookedTrips($request)
    {
        $query = $request->query('query', null);

        if ($query !== null && !$this->checkIfQueryIsValid($query)) {
            return $this->jsonResponse(false, 'Invalid query parameter passed. Please pass "current" or "history".');
        }

        return $this->fetchBookedTrips($request, $query);
    }

    private function checkIfQueryIsValid($query): bool
    {
        return in_array($query, ['current', 'history'], true);
    }

    private function fetchBookedTrips($request, $query = null)
    {
        $currentUser = $request->user();
        $trips = collect();
    
        if ($query === 'current') {
            $trips = Order::where('user_id', $currentUser->id)
                ->where('booking_status', 'ongoing')
                ->whereDate('pickup_date', '=', now()->toDateString())
                ->whereIn('payment_status', ['completed', 'partial'])
                ->get();
        } elseif ($query === 'history') {
            $trips = Order::where('user_id', $currentUser->id)
                ->whereIn('booking_status', ['completed', 'cancelled', 'failed'])
                ->whereDate('pickup_date', '<=', now()->toDateString())
                ->get();
        } else {
            $trips = Order::where('user_id', $currentUser->id)
                ->whereDate('pickup_date', '>=', now()->toDateString())
                ->where('booking_status', 'upcoming')
                ->whereIn('payment_status', ['completed', 'partial'])
                ->get();
        }
    
        return $this->jsonResponse(true, "Fetched trips", $trips);
    }
    
}

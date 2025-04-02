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

        $queryBuilder = Order::where('user_id', $currentUser->id);

        if ($query === 'current') {
            $queryBuilder->where([
                'booking_status' => 'ongoing',
                'pickup_date' => date('Y-m-d'),
            ])->whereIn('payment_status', ['completed', 'partial']);
        } elseif ($query === 'history') {
            $queryBuilder->whereIn('booking_status', ['completed', 'cancelled', 'failed']);
        }

        $trips = $queryBuilder->get();

        return $this->jsonResponse(true, "Fetched trips", $trips);
    }
}

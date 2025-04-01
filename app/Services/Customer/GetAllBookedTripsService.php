<?php

namespace App\Services\Customer;

use App\Models\Order;
use App\Services\CoreService;

class GetAllBookedTripsService extends CoreService
{
    public function getAllBookedTrips($request)
    {
        $query = $request->query('query', '');

        if (!$this->checkIfQueryIsValid($query)) {
            return $this->jsonResponse(false, 'Invalid query parameter passed. Please pass "current" or "history".');
        }

        return $this->fetchBookedTrips($request,$query);
    }

    private function checkIfQueryIsValid($query): bool
    {
        return in_array($query, ['current', 'history'], true);
    }

    private function fetchBookedTrips($request,$query)
    {
        $currentUser = $request->user();

        if ($query === 'current') {

            $trips = Order::where([
                'user_id' => $currentUser->id,
                'booking_status' => 'ongoing',
                'pickup_date' => date('Y-m-d'),
            ])->get();
        } 
        return $this->jsonResponse(true, "Fetched trips for: $query");
    }
}

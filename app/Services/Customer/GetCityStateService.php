<?php

namespace App\Services\Customer;

use App\Models\City;
use App\Models\State;
use Exception;
use Illuminate\Http\JsonResponse;

class GetCityStateService
{
    public function getPlaces($request): JsonResponse
    {
        try {
            $query = trim($request->query('query'));
            $limit = $request->query('limit', 10); // Default to 10 results per page
            

            $cities = City::startsWith("LOWER(name) LIKE LOWER(?)", ["$query%"])
                ->paginate($limit);
            
            if ($cities->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'No matching city found'], 404);
            }

            $locations = $cities->map(function ($city) {
                $state = State::find($city->state_id);
                return [
                    'city' => $city->name,
                    'state' => $state ? $state->name : null,
                    'full_location' => $city->name . ', ' . ($state ? $state->name : 'Unknown')
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Cities and states found',
                'data' => $locations,
                'pagination' => [
                    'current_page' => $cities->currentPage(),
                    'total_pages' => $cities->lastPage(),
                    'total_results' => $cities->total(),
                    'per_page' => $cities->perPage(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
        }
    }
}
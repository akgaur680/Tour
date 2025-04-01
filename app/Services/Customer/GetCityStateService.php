<?php

namespace App\Services\Customer;

use App\Models\City;
use App\Models\State;
use App\Services\CoreService;
use Exception;
use Illuminate\Http\JsonResponse;

class GetCityStateService extends CoreService
{
    public function getPlaces($request): JsonResponse
    {
        try {
            $query = trim($request->query('query', '')); 
            $limit = $request->query('limit', 10); 
    
            if (empty($query)) {
                return response()->json(['status' => false, 'message' => 'Query parameter is required'], 400);
            }
    
            $cities = City::whereRaw("LOWER(name) LIKE LOWER(?)", ["$query%"])
                ->limit($limit)
                ->get();
    
            if ($cities->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'No matching city found'], 404);
            }
    
            $locations = $cities->map(fn($city) => $city->name . ', ' . optional($city->state)->name)->toArray();

            return $this->jsonResponse(true, 'Cities found', $locations);
    
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to fetch data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
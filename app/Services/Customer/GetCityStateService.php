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
    
            $locations = $cities->map(function ($city) {
                return [
                    $city->name . ', ' . optional($city->state)->name
                ];
            });
    
            return response()->json([
                'status' => true,
                'message' => 'Cities found',
                'data' => $locations
            ]);
    
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to fetch data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
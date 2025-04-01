<?php

namespace App\Services\Customer;

use App\Models\Airport;
use App\Services\CoreService;
use Illuminate\Http\JsonResponse;
use Exception;

class GetAirportService  extends CoreService
 {

    public function getAirports($request)  : JsonResponse
    {
        try {
            $query = trim($request->query('query', '')); 
            $limit = $request->query('limit', 10); 
    
            if (empty($query)) {
                return response()->json(['status' => false, 'message' => 'Query parameter is required'], 400);
            }
    
            $airports = Airport::whereRaw("LOWER(name) LIKE LOWER(?)", ["$query%"])
                ->limit($limit)
                ->get();
    
            if ($airports->isEmpty()) {
                return response()->json(['status' => false, 'message' => 'No matching airport found'], 404);
            }
    
            $locations = $airports->map(fn($airport) => $airport->name . ', ' . $airport->state)->toArray();
            $airportIds = $airports->pluck('id')->toArray();
    
            return response()->json([
                'status' => true,
                'message' => 'Airports found',
                'data' => $locations,
                'airport_ids' => $airportIds
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
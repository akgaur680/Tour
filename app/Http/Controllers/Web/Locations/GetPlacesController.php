<?php

namespace App\Http\Controllers\Web\Locations;

use App\Http\Controllers\Controller;
use App\Services\Admin\LocationService\GetAirportService;
use App\Services\Admin\LocationService\GetCityStateService;
use Illuminate\Http\Request;

class GetPlacesController extends Controller
{
    public function getPlaces(Request $request)
    {
        return (new GetCityStateService())->getPlaces($request);
    }

    public function getAirpots(Request $request)
    {
        return (new GetAirportService())->getAirports($request);
    }
}

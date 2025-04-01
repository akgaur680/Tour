<?php

namespace App\Http\Controllers\Web\FixedPricing;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\PricingRequest\AddPricingRequest;
use App\Models\FixedTourPrices;
use App\Services\Admin\FixedPricingServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FixedPricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = FixedTourPrices::with(['originCity', 'originState', 'destinationCity', 'destinationState', 'car', 'airport'])->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('origin', function ($row) {
                    if ($row->trip_type_id == 1) {
                        return $row->originCity->name . ', ' . $row->originState->name;
                    } else if ($row->trip_type_id == 4) {
                        if ($row->origin_city_id == null) {
                            return $row->airport->name;
                        } else {
                            return $row->originCity->name . ', ' . $row->originState->name;
                        }
                    } else {
                        return null;
                    }
                })
                ->editColumn('destination', function ($row) {
                    if ($row->trip_type_id == 1) {
                        return $row->destinationCity->name . ', ' . $row->destinationState->name;
                    } else if ($row->trip_type_id == 4) {
                        if ($row->destination_city_id == null) {
                            return $row->airport->name;
                        } else {
                            return $row->destinationCity->name . ', ' . $row->destinationState->name;
                        }
                    } else {
                        return null;
                    }
                })
                ->editColumn('car_image', function ($row) {
                    return $row->car->car_image ? '<img src="' . asset($row->car->car_image) . '" width="50" height="50"/>' : 'No Image';
                })
                ->rawColumns(['origin', 'destination', 'car_image'])
                ->make(true);
        }

        return view('admin.fixed_pricing.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPricingRequest $request)
    {
        $validated = $request->validated();
        return (new FixedPricingServices)->store($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = FixedTourPrices::with(['originCity', 'originState', 'destinationCity', 'destinationState', 'car', 'airport'])->findorFail($id);
        if($result){
            return response()->json(['status'=> true, 'message' => 'Pricing Found Successfully', 'pricing' => $result]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Error Occured During Getting Pricing']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return (new FixedPricingServices)->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Web\FixedPricing;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\FixedTourPrices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FixedPricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FixedTourPrices::with(['originCity', 'originState', 'destinationCity', 'destinationState', 'car'])->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('profile_image', function ($row) {
                    return $row->user->profile_image ? '<img src="' . ImageHelper::getImageUrl($row->user->profile_image) . '" width="50" height="50"/>' : 'No Image';
                })
               
                ->rawColumns(['profile_image', 'license_image'])
                ->make(true);
        }
    
        return view('/admin/fixed_pricing/index');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

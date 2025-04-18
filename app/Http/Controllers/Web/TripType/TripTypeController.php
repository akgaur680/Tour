<?php

namespace App\Http\Controllers\Web\TripType;

use App\Http\Controllers\Controller;
use App\Models\TripType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TripTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if($request->ajax()){
            $data = TripType::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.trip_type.index');
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

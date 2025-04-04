<?php

namespace App\Http\Controllers\Web\Cars;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CarRequest\CarStoreRequest;
use App\Models\Car;
use App\Services\CarService\CarService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Car::all();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('car_image', function ($row) {
                    return $row->car_image ? '<img src="' . ImageHelper::getImageUrl($row->car_image) . '" width="50" height="50"/>' : 'No Image';
                })
                ->rawColumns(['car_image']) // Ensure HTML is not escaped
                ->make(true);
        }
    
        return view('/admin/cars/index');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarStoreRequest $request)
    {
        $validated = $request->validated();
        return (new CarService)->store($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::findorFail($id);
        if ($car) {
            return response()->json(['status' => true, 'car' => $car]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error in Getting Car Details']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return (new CarService)->edit($id);
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarStoreRequest $request, string $id)
    {
        $validated = $request->validated();
        return (new CarService)->update($validated, $id);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::findorFail($id);
        $delete = $car->delete();
        if ($delete) {

            return response()->json(['status' => true, 'message' => 'Car Deleted Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Error in Deleting Car']);
        }
    }
}

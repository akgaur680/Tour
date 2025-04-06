<?php

namespace App\Http\Controllers\Web\Drivers;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\DriverRequest\DriverStoreRequest;
use App\Http\Requests\Web\DriverRequest\DriverUpdateRequest;
use App\Models\Driver;
use App\Models\User;
use App\Services\DriverService\DriverService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Driver::with('user', 'car')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('profile_image', function ($row) {
                    return $row->user->profile_image ? '<img src="' . ImageHelper::getImageUrl($row->user->profile_image) . '" width="50" height="50"/>' : 'No Image';
                })
                ->editColumn('license_image', function ($row) {
                    return $row->license_image ? '<img src="' . ImageHelper::getImageUrl($row->license_image) . '" width="50" height="50"/>' : 'No Image';
                })
                ->addColumn('is_available', function ($row) {
                    $checked = $row->is_available ? 'checked' : '';
                    return '
                        <div class="form-check form-switch">
                            <input class="form-check-input toggle-availability" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
                })
                ->addColumn('is_approved', function ($row) {
                    $checked = $row->is_approved ? 'checked' : '';
                    return '
                        <div class="form-check form-switch">
                            <input class="form-check-input toggle-approval" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
                })
                ->rawColumns(['profile_image', 'license_image', 'is_available', 'is_approved'])
                ->make(true);
        }

        return view('/admin/drivers/index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverStoreRequest $request)
    {
        $validated = $request->validated();
        return (new DriverService)->store($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Driver::with('user', 'car')->findorFail($id);
        if ($driver) {
            return response()->json(['status' => true, 'driver' => $driver]);
        } else {
            return response()->json(['status' => false, 'message' => 'Error in Getting Driver Details']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return (new DriverService)->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DriverUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        return (new DriverService)->update($validated, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return (new DriverService)->destroy($id);
    }

    public function toggleAvailability(Request $request, $id)
    {
        return (new DriverService())->toggleAvailability($request, $id);
    }

    public function toggleApproval(Request $request, $id)
    {
        return (new DriverService())->toggleApproval($request, $id);
    }
}

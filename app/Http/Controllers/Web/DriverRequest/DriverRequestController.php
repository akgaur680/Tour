<?php

namespace App\Http\Controllers\Web\DriverRequest;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DriverRequestController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data = Driver::with(['user', 'car'])->where('is_approved', '0')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.driver_requests.index');
    }

    public function getDriverRequestDetails($id){
        $driver = Driver::with(['user', 'car'])->where('id', $id)->first();
        if($driver){
            return response()->json(['status' => true, 'message'=> 'Driver Found Successfully', 'driver' => $driver]);
        }
        else{
            return response()->json(['status' => false,'message' => 'Driver Not Found']);
        }
    }

    public function submitApprovalStatus(Request $request, $id){
        $driver = Driver::find($id);
        if($driver){
            $driver->is_approved = $request->is_approved;
            $driver->save();
            return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Driver Not Found']);
        }
    }
}

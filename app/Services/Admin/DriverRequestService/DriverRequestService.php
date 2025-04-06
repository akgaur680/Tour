<?php

namespace App\Services\Admin\DriverRequestService;

use App\Models\Driver;
use App\Models\Order;
use App\Services\CoreService;

class DriverRequestService extends CoreService
{
    public function getDriverRequestDetails(int $id){
        $driver = Driver::with(['user', 'car'])->where('id', $id)->first();
        if($driver){
            return response()->json(['status' => true, 'message'=> 'Driver Found Successfully', 'driver' => $driver]);
        }
        else{
            return response()->json(['status' => false,'message' => 'Driver Not Found']);
        }
    }

    public function submitApprovalStatus($request, int $id){
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
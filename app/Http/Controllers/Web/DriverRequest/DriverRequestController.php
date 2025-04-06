<?php

namespace App\Http\Controllers\Web\DriverRequest;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Services\Admin\DriverRequestService\DriverRequestService;
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
       return (new DriverRequestService)->getDriverRequestDetails($id);
    }

    public function submitApprovalStatus(Request $request, $id){
       return (new DriverRequestService())->submitApprovalStatus($request, $id);
    }
}

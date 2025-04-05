<?php

namespace App\Http\Controllers\Web\VerifyPayment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Admin\VerifyPaymentService\VerifyPaymentService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VerifyPaymentController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $data = Order::with([
                'tripType', 'car', 'user', 'driver',
                'fromAddressCity', 'fromAddressState',
                'toAddressCity', 'toAddressState', 'airport'
            ])
            ->where('payment_verified', 0)
            ->whereNotNull('payment_proof')
            ->whereNotIn('payment_status', ['completed', 'failed'])
            ->orderBy('id', 'desc')
            ->get();
            
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })
                ->editColumn('payment_type', function ($row) {
                    $status = '';
                    if ($row->payment_type == 'Half Payment') {
                        $status = '<span class="badge badge-danger">Half Payment</span>';
                    } else if ($row->payment_type == 'Partial Payment') {
                        $status = '<span class="badge badge-info">Partial</span>';
                    } else if ($row->payment_type == 'Full Payment') {
                        $status = '<span class="badge badge-success">Completed</span>';
                    }
                    return $status;
                })
                ->editColumn('payment_status', function ($row) {
                    $status = '';
                   if ($row->payment_status == 'partial') {
                        $status = '<span class="badge badge-info">Partial</span>';
                    } else if ($row->payment_status == 'completed') {
                        $status = '<span class="badge badge-success">Completed</span>';
                    }
                    else if($row->payment_status == 'pending'){
                        $status = '<span class="badge badge-danger">Pending</span>';
                    }
                    else if($row->payment_status == 'failed'){
                        $status = '<span class="badge badge-danger" >Failed</span>';
                    }
                    return $status;
                })
                ->rawColumns(['created_at', 'payment_type', 'payment_status'])
                ->make(true);
        }
        return view('admin.verify_payments.index');
    }

      // Show payment details
      public function getVerifyPaymentDetails($id)
      {
         return (new VerifyPaymentService())->getVerifyPaymentDetails($id);
      }
  
      public function updateVerifyPaymentStatus($id, Request $request){
        return (new VerifyPaymentService())->updateVerifyPaymentStatus($id, $request);
      }
}

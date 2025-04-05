<?php

namespace App\Http\Controllers\Web\VerifyPayment;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
          $order = Order::with('user', 'car')->find($id);
  
          if (!$order) {
              return response()->json(['status' => false, 'message' => 'Order not found']);
          }
  
          $data = [
              'id' => $order->id,
              'customer_name' => optional($order->user)->name,
              'customer_email' => optional($order->user)->email,
              'customer_mobile' => optional($order->user)->mobile,
              'customer_address' => optional($order->user)->address,
              'pickup_location' => $order->pickup_location,
              'drop_location' => $order->drop_location,
              'pickup_date' => $order->pickup_date,
              'pickup_time' => $order->pickup_time,
              'car_name' => optional($order->car)->name,
              'booking_status' => $order->booking_status,
              'payment_status' => $order->payment_status,
              'received_amount' => $order->received_amount,
              'total_amount' => $order->total_amount,
              'payment_proof' => $order->payment_proof,
              'booking_token' => $order->booking_token,
          ];
  
          return response()->json([
              'status' => true,
              'verify_payment' => $data,
          ]);
      }
  
      public function updateVerifyPaymentStatus($id, Request $request){
          $order = Order::find($id);
          if($order){
            
          if($request->verify_action == 'approve'){
            $order->payment_verified = 1;
            if($order->total_amount == $order->received_amount){
              $order->payment_status = 'completed';
            }
            else{
              $order->payment_status = 'partial';
            }
            $order->payment_status = 'completed';
          }
          else if($request->verify_action == 'reject'){
              $order->payment_verified = 0;
              $order->payment_status = 'failed';
          }
         
          $order->save();
  
          return response()->json(['status' => true, 'message' => 'Payment status updated successfully']);
          }
          else{
            return response()->json(['status' => false, 'message' => 'Error in Finding Booking Details']);
          }
      }
}

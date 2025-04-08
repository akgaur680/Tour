<?php

namespace App\Services\Admin\VerifyPaymentService;

use App\Models\Order;
use App\Services\CoreService;

class VerifyPaymentService extends CoreService
{
    public function getVerifyPaymentDetails(int $id){
        $order = Order::with('user', 'car')->find($id);
  
        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found']);
        }

        $data = [
            'id' => $order->id,
            'customer_name' => optional($order->user)->name,
            'customer_email' => optional($order->user)->email,
            'customer_mobile' => optional($order->user)->mobile_no,
            'customer_address' => optional($order->user)->address,
            'pickup_location' => $order->pickup_location,
            'drop_location' => $order->drop_location,
            'pickup_date' => $order->pickup_date,
            'pickup_time' => $order->pickup_time,
            'car_name' => optional($order->car)->car_type,
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

    public function updateVerifyPaymentStatus(int $id, $request){
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
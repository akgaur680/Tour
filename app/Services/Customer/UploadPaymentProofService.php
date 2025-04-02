<?php

namespace App\Services\Customer;

use App\Helpers\ImageHelper;
use App\Models\Order;
use App\Services\CoreService;
use Illuminate\Support\Facades\Storage;

class UploadPaymentProofService extends CoreService
{
    public function uploadPaymentProof($request)
    {
        $customer = $request->user();

        if (!$request->hasFile('payment_proof')) {
            return $this->jsonResponse(false, 'No payment proof file uploaded.');
        }

        $payment_proof = $request->file('payment_proof');

        $imageName = time() . '_' . $customer->id . '_payment_proof.' . $payment_proof->getClientOriginalExtension();

        $storedImagePath = ImageHelper::storeImage($payment_proof, 'payment_proof');

        if (!$storedImagePath) {
            return $this->jsonResponse(false, 'Failed to store payment proof.');
        }

        $checkPaymentType = Order::where([
            'booking_token' => $request->booking_token,
            'user_id' => $customer->id
        ])->select('payment_type' , 'total_amount')->first();

        $recievedAmount = $this->checkPaymentType($checkPaymentType->payment_type , $checkPaymentType->total_amount); 

        $savePaymentProof = Order::where([
            'booking_token' => $request->booking_token,
            'user_id' => $customer->id
        ])->update(['payment_proof' => $storedImagePath ,'received_amount' => $recievedAmount]);

        if (!$savePaymentProof) {
            return $this->jsonResponse(false, 'Failed to upload payment proof.');
        }
        
        return $this->jsonResponse(true, 'Payment proof uploaded successfully.');
    }

    private function checkPaymentType($paymentType, $totalAmount)
    {
        return match ($paymentType) {
            'Half Payment' => $totalAmount / 2,
            'Partial Payment' => $totalAmount / 4,
            'Full Payment' => $totalAmount,
            'Pay on Delivery' => $totalAmount,
            default => 0,
        };
    }
}

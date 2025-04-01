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

        $savePaymentProof = Order::where([
            'booking_token' => $request->booking_token,
            'user_id' => $customer->id
        ])->update(['payment_proof' => $storedImagePath]);

        if (!$savePaymentProof) {
            return $this->jsonResponse(false, 'Failed to upload payment proof.');
        }
        
        return $this->jsonResponse(true, 'Payment proof uploaded successfully.');
    }
}

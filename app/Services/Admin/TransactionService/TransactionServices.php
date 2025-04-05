<?php

namespace App\Services\Admin\TransactionService;

use App\Models\Order;
use App\Services\CoreService;

class TransactionServices extends CoreService
{
    public function getTransactionDetails($id){
        $transaction = Order::with(['tripType', 'car', 'user', 'driver', 'fromAddressCity', 'fromAddressState', 'toAddressCity', 'toAddressState', 'airport'])->find($id);
        if ($transaction) {
            return response()->json(['status' => true, 'message' => 'Transaction Found Successfully', 'transaction' => $transaction]);
        } else {
            return response()->json(['status' => false, 'message' => 'Transaction Not Found']);
        }
    }

}
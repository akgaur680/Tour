<?php

namespace App\Services\Admin\BookingService;

use App\Models\Order;
use App\Services\CoreService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;
use Yajra\DataTables\DataTables;

class BookingService extends CoreService
{
    private $model;
    public function __construct()
    {
        $this->model = new Order();
    }

    public function cancelBooking($request)
    {
        $trip = Order::where(['booking_token' => $request])->first();
        $trip->booking_status = 'cancelled';
        $trip->save();
        if ($trip) {
            return $this->jsonResponse(true, 'Booking Cancelled Successfully');
        } else {
            return $this->jsonResponse(false, 'Booking not found');
        }
    }
}

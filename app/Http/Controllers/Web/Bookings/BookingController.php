<?php

namespace App\Http\Controllers\Web\Bookings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\BookingRequest\CancelBookingRequest;
use App\Http\Requests\Web\BookingRequest\ChangeStatusRequest;
use App\Models\Order;
use App\Services\Admin\BookingService\BookingService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BookingController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Order::with(['tripType', 'car', 'user', 'driver', 'fromAddressCity', 'fromAddressState', 'toAddressCity', 'toAddressState', 'airport'])->orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })
                ->editColumn('payment_status', function ($row) {
                    $status = '';
                    if ($row->payment_status == 'pending') {
                        $status = '<span class="badge badge-danger">Pending</span>';
                    } else if ($row->payment_status == 'partial') {
                        $status = '<span class="badge badge-info">Partial</span>';
                    } else if ($row->payment_status == 'completed') {
                        $status = '<span class="badge badge-success">Completed</span>';
                    }
                    else if($row->payment_status == 'failed'){
                        $status = '<span class="badge badge-danger">Failed</span>';
                    }
                    return $status;
                })
                // ->editColumn('booking_status', function ($row) {
                //     $status = '';
                //     if ($row->booking_status == 'upcoming') {
                //         $status = '<span class="badge badge-warning">Up-Coming</span>';
                //     } else if ($row->booking_status == 'ongoing') {
                //         $status = '<span class="badge badge-info">On-Going</span>';
                //     } else if ($row->booking_status == 'completed') {
                //         $status = '<span class="badge badge-success">Completed</span>';
                //     } else if ($row->booking_status == 'cancelled') {
                //         $status = '<span class="badge badge-danger">Cancelled</span>';
                //     }
                //     return $status;
                // })
                ->rawColumns(['created_at', 'payment_status'])
                ->make(true);
        }
        return view('admin.bookings.index');
    }

    public function cancelBooking($token)
    {
        // $validated = $request->validated();
        return (new BookingService)->cancelBooking($token);
    }
}

<?php

namespace App\Http\Controllers\Web\Bookings;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $data = Order::with(['tripType', 'car', 'user', 'driver', 'fromAddressCity', 'fromAddressState', 'toAddressCity', 'toAddressState', 'airport'])->get();
        dd($data);
        if($request->ajax()) {
            $data = Order::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                   return $row->created_at->format('d-m-Y');
                })
                ->rawColumns(['created_at'])
                ->make(true);
        }
        return view('admin.bookings.index');
    }
}

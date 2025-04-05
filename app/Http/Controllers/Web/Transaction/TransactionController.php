<?php

namespace App\Http\Controllers\Web\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Services\Admin\TransactionService\TransactionServices;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Order::with(['tripType', 'car', 'user', 'driver', 'fromAddressCity', 'fromAddressState', 'toAddressCity', 'toAddressState', 'airport'])->where('payment_status', 'completed')->orWhere('payment_status', 'partial')->orderBy('id', 'desc')->get();
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
                    return $status;
                })
                ->rawColumns(['created_at', 'payment_type', 'payment_status'])
                ->make(true);
        }
        return view('admin.transactions.index');
    }

    public function getTransactionDetails($id){
        return (new TransactionServices())->getTransactionDetails($id);
    }


}

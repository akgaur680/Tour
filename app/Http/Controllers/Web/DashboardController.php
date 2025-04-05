<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $bookings = Order::with(['tripType', 'car', 'user', 'driver', 'fromAddressCity', 'fromAddressState', 'toAddressCity', 'toAddressState', 'airport'])->orderBy('id', 'desc')->limit(5)->get();
        $bookingsCount = Order::whereNotIn('booking_status', ['cancelled', 'failed', 'completed'])->count();
        $users = User::whereRole('customer')->count();
        $cars = Car::count();
        $drivers = Driver::where('is_available', 1)->where('is_approved', 1)->count();
        return view('dashboard.index', compact('bookings', 'users', 'cars', 'drivers', 'bookingsCount'));
    }
}

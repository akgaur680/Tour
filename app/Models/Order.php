<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TripType;
use App\Models\Car;
use App\Models\User;
use App\Models\Airport;
use App\Models\City;
use App\Models\State;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'from_address_city_id',
        'from_address_state_id',
        'to_address_city_id',
        'to_address_state_id',
        'trip_type_id',
        'return_date',
        'pickup_date',
        'pickup_time',
        'airport_id',
        'user_id',
        'pickup_location',
        'drop_location',
        'car_id',
        'is_chauffeur_needed',
        'preffered_chauffeur_language',
        'is_new_car_promised',
        'is_cab_luggage_needed',
        'is_diesel_car_needed',
        'received_amount',
        'total_amount',
        'total_distance',
        'total_hours',
        'payment_type',
        'payment_status',
        'order_status',
        'booking_status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
    ];

    public function tripType()
    {
        return $this->belongsTo(TripType::class, 'trip_type_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fromAddressCity()
    {
        return $this->belongsTo(City::class, 'from_address_city_id');
    }

    public function fromAddressState()
    {
        return $this->belongsTo(State::class, 'from_address_state_id');
    }

    public function toAddressCity()
    {
        return $this->belongsTo(City::class, 'to_address_city_id');
    }

    public function toAddressState()
    {
        return $this->belongsTo(State::class, 'to_address_state_id');
    }

    public function airport()
    {
        return $this->belongsTo(Airport::class, 'airport_id');
    }

}

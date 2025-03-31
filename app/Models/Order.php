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
        'booking_token',
        'from_address_city_id',
        'from_address_state_id',
        'to_address_city_id',
        'to_address_state_id',
        'trip_type_id',
        'return_date',
        'pickup_date',
        'pickup_time',
        'airport_id',
        'from_airport',
        'to_airport',
        'user_id',
        'driver_id',
        'pickup_location',
        'drop_location',
        'car_id',
        'is_chauffeur_needed',
        'chauffeur_price',
        'preffered_chauffeur_language',
        'is_new_car_promised',
        'new_car_price',
        'is_cab_luggage_needed',
        'cab_luggage_price',
        'is_diesel_car_needed',
        'diesel_car_price',
        'received_amount',
        'original_amount',
        'total_distance',
        'total_hours',
        'payment_status',
        'booking_status',
    ];

    protected $casts = [
        'from_airport' => 'boolean',
        'to_airport' => 'boolean',
        'is_chauffeur_needed' => 'boolean',
        'is_new_car_promised' => 'boolean',
        'is_cab_luggage_needed' => 'boolean',
        'is_diesel_car_needed' => 'boolean',
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

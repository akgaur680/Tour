<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarTripType extends Model
{
    protected $fillable = [
        'car_id',
        'trip_type_id',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function tripType()
    {
        return $this->belongsTo(TripType::class);
    }
}

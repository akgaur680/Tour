<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedTourPrices extends Model
{
    protected $table = 'fixed_tour_prices';

    protected $fillable = [
        'origin_city_id',
        'origin_state_id',
        'destination_city_id',
        'destination_state_id',
        'car_id',
        'price',
        'trip_type_id',
        'airport_id'
    ];

    public function originCity()
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }
    public function originState()
    {
        return $this->belongsTo(State::class, 'origin_state_id');
    }
    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }
    public function destinationState()
    {
        return $this->belongsTo(State::class, 'destination_state_id');
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function airport(){
        return $this->belongsTo(Airport::class);    
    }
}

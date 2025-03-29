<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripType extends Model
{
    protected $fillable = ['name', 'slug'];
    protected $table = 'trip_types';

    public function carTripTypes()
    {
        return $this->hasMany(CarTripType::class);
    }

}

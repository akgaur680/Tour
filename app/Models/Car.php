<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';
    protected $primaryKey = 'id';
    protected $fillable = [
        'car_number',
        'car_model',
        'car_type',
        'seats',
        'ac',
        'luggage_limit',
        'price_per_km',
        'car_image'
    ];
}

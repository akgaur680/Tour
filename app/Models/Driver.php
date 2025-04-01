<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'drivers';

    protected $fillable = [
        'user_id',
        'car_id',
        'driving_license',
        'license_expiry',
        'license_image',
        'adhaar_number',
        'adhaar_image_front',
        'adhaar_image_back',
        'is_approved',
        'is_available',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}

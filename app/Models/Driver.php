<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
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
        'is_available'
    ];
    protected $casts = [
        'is_approved' => 'boolean',
        'is_available' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function getLicenseImageUrlAttribute()
    {
        return $this->license_image ? asset('storage/' . $this->license_image) : null;
    }
    public function getAdhaarImageFrontUrlAttribute()
    {
        return $this->adhaar_image_front ? asset('storage/' . $this->adhaar_image_front) : null;
    }
    public function getAdhaarImageBackUrlAttribute()
    {
        return $this->adhaar_image_back ? asset('storage/' . $this->adhaar_image_back) : null;
    }
    public function getProfilePicUrlAttribute()
    {
        return $this->user->profile_pic ? asset('storage/' . $this->user->profile_pic) : null;
    }
    public function getCarImageUrlAttribute()
    {
        return $this->car->car_image ? asset('storage/' . $this->car->car_image) : null;
    }
    public function getCarNameAttribute()
    {
        return $this->car->car_name ?? 'No Car Assigned';
    }
}

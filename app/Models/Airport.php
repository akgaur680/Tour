<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'name',
        'latitude_deg',
        'longitude_deg',
        'state',
    ];

    public function getCoordinates()
    {
        return [
            'latitude' => $this->latitude_deg,
            'longitude' => $this->longitude_deg,
        ];
    }
}

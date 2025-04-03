<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    public function run()
    {
        $cars = [
            [
                'car_number' => 'PB10AB1234',
                'car_model' => 'Toyota Innova',
                'car_type' => 'SUV',
                'seats' => 7,
                'ac' => true,
                'luggage_limit' => 4,
                'price_per_km' => 12,
                'price_per_hour' => 200,
                'car_image' => 'cars/innova.jpg',
            ],
            [
                'car_number' => 'HR26XY5678',
                'car_model' => 'Maruti Swift',
                'car_type' => 'Hatchback',
                'seats' => 5,
                'ac' => true,
                'luggage_limit' => 2,
                'price_per_km' => 10,
                'price_per_hour' => 100,
                'car_image' => 'cars/swift.jpg',
            ],
            [
                'car_number' => 'DL8CAF8901',
                'car_model' => 'Hyundai Creta',
                'car_type' => 'SUV',
                'seats' => 5,
                'ac' => true,
                'luggage_limit' => 3,
                'price_per_km' => 14,
                'price_per_hour' => 400,
                'car_image' => 'cars/creta.jpg',
            ],
            [
                'car_number' => 'UP16GH2345',
                'car_model' => 'Honda City',
                'car_type' => 'Sedan',
                'seats' => 5,
                'ac' => true,
                'luggage_limit' => 2,
                'price_per_km' => 13,
                'price_per_hour' => 500,
                'car_image' => 'cars/city.jpg',
            ],
            [
                'car_number' => 'RJ14JK6789',
                'car_model' => 'Tata Tiago',
                'car_type' => 'Hatchback',
                'seats' => 5,
                'ac' => false,
                'luggage_limit' => 2,
                'price_per_km' => 9,
                'price_per_hour' => 0,
                'car_image' => 'cars/tiago.jpg',
            ],
            [
                'car_number' => 'MH12LM3456',
                'car_model' => 'Mahindra XUV500',
                'car_type' => 'SUV',
                'seats' => 7,
                'ac' => true,
                'luggage_limit' => 4,
                'price_per_km' => 15,
                'price_per_hour' => 600,
                'car_image' => 'cars/xuv500.jpg',
            ],
            [
                'car_number' => 'GJ01NO5678',
                'car_model' => 'Ford Ecosport',
                'car_type' => 'Compact SUV',
                'seats' => 5,
                'ac' => true,
                'luggage_limit' => 3,
                'price_per_km' => 11,
                'price_per_hour' => 300,
                'car_image' => 'cars/ecosport.jpg',
            ],
            [
                'car_number' => 'WB20QR6789',
                'car_model' => 'Volkswagen Polo',
                'car_type' => 'Hatchback',
                'seats' => 5,
                'ac' => true,
                'luggage_limit' => 2,
                'price_per_km' => 10,
                'price_per_hour' => 0,
                'car_image' => 'cars/polo.jpg',
            ],
            [
                'car_number' => 'KA05ST2345',
                'car_model' => 'Nissan Magnite',
                'car_type' => 'Compact SUV',
                'seats' => 5,
                'ac' => true,
                'luggage_limit' => 3,
                'price_per_km' => 12,
                'price_per_hour' => 0,
                'car_image' => 'cars/magnite.jpg',
            ],
            [
                'car_number' => 'TN09UV4567',
                'car_model' => 'Skoda Octavia',
                'car_type' => 'Sedan',
                'seats' => 5,
                'ac' => true,
                'luggage_limit' => 3,
                'price_per_km' => 14,
                'price_per_hour' => 0,
                'car_image' => 'cars/octavia.jpg',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}

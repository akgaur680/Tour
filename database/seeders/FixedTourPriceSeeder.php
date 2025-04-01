<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FixedTourPrices;

class FixedTourPriceSeeder extends Seeder
{
    public function run()
    {
        $tourPrices = [
            [
                'origin_city_id' => 26,
                'origin_state_id' => 20,
                'destination_city_id' => 1,
                'destination_state_id' => 33,
                'car_id' => 1,
                'price' => 1500,
                'trip_type_id' => 1
            ],
            [
                'origin_city_id' => 26,
                'origin_state_id' => 20,
                'destination_city_id' => 1,
                'destination_state_id' => 33,
                'car_id' => 2,
                'price' => 2000,
                'trip_type_id' => 1
            ],
            [
                'origin_city_id' => 26,
                'origin_state_id' => 20,
                'destination_city_id' => 1,
                'destination_state_id' => 33,
                'car_id' => 3,
                'price' => 4200,
                'trip_type_id' => 2
            ],
            [
                'origin_city_id' => 26,
                'origin_state_id' => 20,
                'destination_city_id' => 1,
                'destination_state_id' => 33,
                'car_id' => 4,
                'price' => 2500,
                'trip_type_id' => 2
            ],
            [
                'origin_city_id' => 26,
                'origin_state_id' => 20,
                'destination_city_id' => 1,
                'destination_state_id' => 33,
                'car_id' => 6,
                'price' => 6210,
                'trip_type_id' => 3
            ],
            [
                'origin_city_id' => 26,
                'origin_state_id' => 20,
                'airport_id' => 427,
                'car_id' => 5,
                'price' => 5000,
                'trip_type_id' => 4
            ],
            [
                'airport_id' => 427,
                'destination_city_id' => 1,
                'destination_state_id' => 33,
                'car_id' => 9,
                'price' => 7500,
                'trip_type_id' => 4
            ],
        ];

        foreach ($tourPrices as $tourPrice) {
            FixedTourPrices::create($tourPrice);
        }
    }
}

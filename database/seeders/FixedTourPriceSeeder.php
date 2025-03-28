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
                'origin_city_id' => 14088,
                'origin_state_id' => 20,
                'destination_city_id' => 14063,
                'destination_state_id' => 33,
                'car_id' => 1,
                'price' => 1500,
            ],
            [
                'origin_city_id' => 14088,
                'origin_state_id' => 20,
                'destination_city_id' => 14063,
                'destination_state_id' => 33,
                'car_id' => 2,
                'price' => 2000,
            ],
            [
                'origin_city_id' => 14088,
                'origin_state_id' => 20,
                'destination_city_id' => 14063,
                'destination_state_id' => 33,
                'car_id' => 3,
                'price' => 4200,
            ],
            [
                'origin_city_id' => 14088,
                'origin_state_id' => 20,
                'destination_city_id' => 14063,
                'destination_state_id' => 33,
                'car_id' => 4,
                'price' => 2500,
            ],
            [
                'origin_city_id' => 14088,
                'origin_state_id' => 20,
                'destination_city_id' => 14063,
                'destination_state_id' => 33,
                'car_id' => 6,
                'price' => 6210,
            ],
            [
                'origin_city_id' => 14088,
                'origin_state_id' => 20,
                'destination_city_id' => 14063,
                'destination_state_id' => 33,
                'car_id' => 5,
                'price' => 5000,
            ],
            [
                'origin_city_id' => 14088,
                'origin_state_id' => 20,
                'destination_city_id' => 14063,
                'destination_state_id' => 33,
                'car_id' => 9,
                'price' => 7500,
            ],
        ];

        foreach ($tourPrices as $tourPrice) {
            FixedTourPrices::create($tourPrice);
        }
    }
}

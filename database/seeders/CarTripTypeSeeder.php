<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarTripTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carIds = range(1, 10);
        $tripTypeIds = range(1, 4);

        $data = [];

        foreach ($carIds as $carId) {
            $assignedTripTypes = array_rand(array_flip($tripTypeIds), rand(1, count($tripTypeIds)));

            foreach ((array) $assignedTripTypes as $tripTypeId) {
                $data[] = [
                    'car_id' => $carId,
                    'trip_type_id' => $tripTypeId,
                ];
            }
        }

        DB::table('car_trip_types')->insert($data);
    }
}

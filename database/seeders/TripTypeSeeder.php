<?php

namespace Database\Seeders;

use App\Models\TripType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tripTypes = [
            ['name' => 'One Way' , 'slug' => 'one-way'],
            ['name' => 'Round Trip' , 'slug' => 'round-trip'],
            ['name' => 'Local' , 'slug' => 'local'],
            ['name' => 'Airport' , 'slug' => 'airport']
        ];

        foreach ($tripTypes as $tripType) {
            TripType::create($tripType);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $drivers = [];

        for ($i = 1; $i <= 3; $i++) { 
            $drivers[] = [
                'user_id' => rand(12, 14),
                'car_id' => rand(1, 10),
                'driving_license' => 'DL-' . strtoupper(Str::random(10)),
                'license_expiry' => now()->addYears(rand(1, 5)), 
                'license_image' => 'licenses/license_' . $i . '.jpg',
                'adhaar_number' => rand(100000000000, 999999999999),
                'adhaar_image_front' => 'aadhaar/front_' . $i . '.jpg',
                'adhaar_image_back' => 'aadhaar/back_' . $i . '.jpg',
                'is_approved' => rand(0, 1),
                'is_available' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('drivers')->insert($drivers);
    }
}

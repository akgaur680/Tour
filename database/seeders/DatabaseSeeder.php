<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\CarSeeder;
use Database\Seeders\StatesTableSeeder;
use Database\Seeders\FixedTourPriceSeeder;
use Database\Seeders\TripTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // $this->call(RolePermissionSeeder::class);
        // $this->call(AdminSeeder::class);
        // $this->call(StatesTableSeeder::class);
        // $this->call(CarSeeder::class);
        // $this->call(FixedTourPriceSeeder::class);
        // $this->call(CarTripTypeSeeder::class);
        // $this->call(TripTypeSeeder::class);
        // $this->call(UserSeeder::class);
        $this->call(DriverSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

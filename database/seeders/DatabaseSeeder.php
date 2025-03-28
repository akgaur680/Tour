<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\StatesTableSeeder;
use Database\Seeders\FixedTourPriceSeeder;

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
        $this->call(FixedTourPriceSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

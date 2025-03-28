<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
<<<<<<< HEAD
=======
        $this->call(RolePermissionSeeder::class);
        $this->call(AdminSeeder::class);
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
<<<<<<< HEAD

        $this->call([
            // AdminSeeder::class,
            TripTypeSeeder::class,
        ]);
=======
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
    }
}

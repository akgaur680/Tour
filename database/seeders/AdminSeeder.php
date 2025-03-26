<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'mobile_no'=> '1234567890',
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
            'mobile_verified' => true,
        ]);
        $superAdmin->assignRole('Super Admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'mobile_no' => '9874563210',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'mobile_verified' => true,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

    }
}

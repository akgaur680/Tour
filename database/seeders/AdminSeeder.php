<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Create Super Admin User
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

        // ✅ Create Admin User
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

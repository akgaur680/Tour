<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =  [
        [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => null,
            'mobile_no' => '9876543210',
            'otp' => null,
            'otp_expiry' =>null,
            'role' => 'driver',
            'mobile_verified' => true,
        ],
        [
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'password' => null,
            'mobile_no' => '9876543211',
            'otp' => null,
            'otp_expiry' =>null,
            'role' => 'driver',
            'mobile_verified' => true,
        ],
        [
            'name' => 'David Johnson',
            'email' => 'davidjohnson@example.com',
            'password' => null,
            'mobile_no' => '9876543212',
            'otp' => null,
            'otp_expiry' =>null,
            'role' => 'driver',
            'mobile_verified' => true,
        ],
    ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

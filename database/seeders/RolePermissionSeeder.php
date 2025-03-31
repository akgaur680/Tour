<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear Cached Permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ✅ Create Permissions for Web (Admins & Super Admin)
        $webPermissions = [
            'manage drivers',
            'add drivers',
            'update drivers',
            'view drivers',
            'delete drivers',
            // Car-related permissions for web users
            'add cars',
            'update cars',
            'view cars',
            'delete cars',
        ];

        foreach ($webPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ✅ Create Permissions for API (Drivers & Customers)
        $apiPermissions = [
            'add cars',
            'update cars',
            'view cars',
            'delete cars',
            'create orders'
        ];

        foreach ($apiPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        // ✅ Create Roles with Proper Guards
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $driver = Role::firstOrCreate(['name' => 'Driver', 'guard_name' => 'api']);
        $customer = Role::firstOrCreate(['name' => 'Customer', 'guard_name' => 'api']);

        // ✅ Assign Web Permissions to Web Roles
        $superAdmin->givePermissionTo(Permission::where('guard_name', 'web')->pluck('name')->toArray());
        $admin->givePermissionTo([
            'manage drivers',
            'add drivers',
            'update drivers',
            'view drivers',
            'delete drivers',
            'add cars',
            'update cars',
            'view cars',
            'delete cars',
        ]);

        // ✅ Assign API Permissions to API Roles
        $driver->givePermissionTo(Permission::where('guard_name', 'api')->pluck('name')->toArray());

        $customer->givePermissionTo([
            'create orders'
        ]);
    }
}

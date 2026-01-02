<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage users',
            'manage subscriptions',
            'manage roles',
            'manage permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        // Admin Role
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        // Super Admin Role
        $superAdminRole = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        // Assign permissions
        $adminRole->syncPermissions([
            'manage users',
            'manage subscriptions',
        ]);

        // Super Admin gets ALL
        $superAdminRole->syncPermissions(Permission::all());
    }
}


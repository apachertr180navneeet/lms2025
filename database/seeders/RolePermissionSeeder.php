<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define some default permissions and roles used by the app
        $permissions = [
            'manage users',
            'manage courses',
            'view reports',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Give admin all permissions
        $admin->syncPermissions(Permission::all());

        // Assign admin role to a default user if found.
        // Prefer explicitly configured admin email, otherwise pick the first user.
        $adminEmail = env('ADMIN_EMAIL');
        $appUser = null;
        if ($adminEmail) {
            $appUser = User::where('email', $adminEmail)->first();
        }

        if (! $appUser) {
            $appUser = User::orderBy('id')->first();
        }

        if ($appUser) {
            $appUser->assignRole($admin);
        }
    }
}

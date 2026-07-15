<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::findByName('Admin');

        $admin->syncPermissions([
            'manage users',
            'manage students',
            'manage teachers',
            'manage courses',
            'manage grades',
            'manage attendance',
            'manage subjects',
            'view reports',
            'view dashboard',
        ]);

        $editor = Role::findByName('Editor');

        $editor->syncPermissions([
            'manage students',
            'manage grades',
            'manage attendance',
            'view dashboard',
        ]);

        $student = Role::findByName('Student');

        $student->syncPermissions([
            'view own profile',
            'view own grades',
            'view own attendance',
        ]);
    }
}

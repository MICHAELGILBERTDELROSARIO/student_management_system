<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            'manage users',
            'manage students',
            'manage teachers',
            'manage courses',
            'manage grades',
            'manage attendance',
            'manage subjects',
            'view reports',
            'view dashboard',

            'view own profile',
            'view own grades',
            'view own attendance',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }
    }
}

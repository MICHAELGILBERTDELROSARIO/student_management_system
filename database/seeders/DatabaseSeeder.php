<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CourseSeeder::class,
            SubjectSeeder::class,
            StudentSeeder::class,
            RoleSeeder::class,
            GradeSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,

        ]);
    }
}

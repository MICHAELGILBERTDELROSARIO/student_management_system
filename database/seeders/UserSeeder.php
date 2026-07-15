<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);
        $studentRole = Role::firstOrCreate(['name' => 'Student']);

        $users = [
            [
                'name' => 'Site Admin',
                'email' => 'admin@school.test',
                'password' => bcrypt('password'),
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'Sample Student',
                'email' => 'student@school.test',
                'password' => bcrypt('password'),
                'role' => User::ROLE_STUDENT,
            ],
            [
                'name' => 'Content Editor',
                'email' => 'editor@school.test',
                'password' => bcrypt('password'),
                'role' => User::ROLE_EDITOR,
            ],
        ];

        foreach ($users as $user) {
            $model = User::updateOrCreate(['email' => $user['email']], $user);

            match ($user['role']) {
                User::ROLE_ADMIN => $model->syncRoles([$adminRole]),
                User::ROLE_EDITOR => $model->syncRoles([$editorRole]),
                default => $model->syncRoles([$studentRole]),
            };
        }
    }
}

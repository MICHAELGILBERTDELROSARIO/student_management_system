<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::where('course_code', 'BSIT')->first();

        $students = [
            ['student_number' => '2024-0001', 'first_name' => 'John', 'last_name' => 'Doe', 'gender' => 'male', 'birth_date' => '2002-03-15', 'course_id' => $course?->id],
            ['student_number' => '2024-0002', 'first_name' => 'Jane', 'last_name' => 'Smith', 'gender' => 'female', 'birth_date' => '2003-07-22', 'course_id' => $course?->id],
            ['student_number' => '2024-0003', 'first_name' => 'Mike', 'last_name' => 'Johnson', 'gender' => 'male', 'birth_date' => '2001-11-05', 'course_id' => $course?->id],
        ];

        foreach ($students as $data) {
            $email = strtolower($data['first_name'] . '.' . $data['last_name'] . '@example.com');

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $data['first_name'] . ' ' . $data['last_name'],
                    'password' => bcrypt('password'),
                    'role' => User::ROLE_STUDENT,
                ]
            );

            Student::updateOrCreate(
                ['student_number' => $data['student_number']],
                array_merge($data, ['user_id' => $user->id])
            );
        }
    }
}

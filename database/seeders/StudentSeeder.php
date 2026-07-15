<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::where('course_code', 'BSIT')->first();

        $students = [
            ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john.doe@example.com', 'password' => bcrypt('password'), 'gender' => 'male', 'birth_date' => '2002-03-15', 'course_id' => $course?->id, 'year_level' => '1st Year'],
            ['first_name' => 'Jane', 'last_name' => 'Smith', 'email' => 'jane.smith@example.com', 'password' => bcrypt('password'), 'gender' => 'female', 'birth_date' => '2003-07-22', 'course_id' => $course?->id, 'year_level' => '2nd Year'],
            ['first_name' => 'Mike', 'last_name' => 'Johnson', 'email' => 'mike.johnson@example.com', 'password' => bcrypt('password'), 'gender' => 'male', 'birth_date' => '2001-11-05', 'course_id' => $course?->id, 'year_level' => '3rd Year'],
        ];

        foreach ($students as $data) {
            $user = User::create([
                'name' => trim($data['first_name'].' '.$data['last_name']),
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => User::ROLE_STUDENT,
            ]);

            $user->assignRole('Student');

            Student::create([
                'student_number' => $data['student_number'] ?? null,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'birth_date' => $data['birth_date'],
                'course_id' => $data['course_id'],
                'year_level' => $data['year_level'],
                'user_id' => $user->id,
            ]);
        }
    }
}

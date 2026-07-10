<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::firstOrCreate(
            ['course_code' => 'BSIT'],
            ['course_name' => 'Bachelor of Science in Information Technology']
        );
    }
}

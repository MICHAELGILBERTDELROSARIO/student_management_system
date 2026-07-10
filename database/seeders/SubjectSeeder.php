<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::where('course_code', 'BSIT')->first();

        $subjects = [
            'Programming Fundamentals',
            'Database Management Systems',
            'Web Development',
            'Computer Networks',
            'Systems Analysis and Design',
        ];

        foreach ($subjects as $subjectName) {
            $subject = Subject::firstOrCreate(['subject_name' => $subjectName]);

            if ($course && ! $subject->courses()->where('course_id', $course->id)->exists()) {
                $subject->courses()->attach($course->id);
            }
        }
    }
}

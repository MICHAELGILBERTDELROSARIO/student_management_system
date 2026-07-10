<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::all();

        Student::all()->each(function ($student) use ($subjects) {
            foreach ($subjects as $subject) {
                $g1 = rand(70, 95);
                $g2 = rand(70, 95);
                $g3 = rand(70, 95);
                $g4 = rand(70, 95);
                $final = round(($g1 + $g2 + $g3 + $g4) / 4, 2);
                $result = $final >= 75 ? 'PASS' : 'FAIL';

                Grade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'first_grading' => $g1,
                    'second_grading' => $g2,
                    'third_grading' => $g3,
                    'fourth_grading' => $g4,
                    'final_grade' => $final,
                    'result' => $result,
                ]);
            }
        });
    }
}

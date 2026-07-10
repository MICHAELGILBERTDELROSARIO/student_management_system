<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $passed = Grade::where('result', 'PASS')->count();
        $failed = Grade::where('result', 'FAIL')->count();

        $studentsPerCourse = Course::withCount('students')
            ->orderBy('course_name')
            ->get(['id', 'course_name', 'course_code']);

        $data = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_subjects' => Subject::count(),
            'average_final_grade' => Grade::avg('final_grade'),
            'passed_grades' => $passed,
            'failed_grades' => $failed,
            'students_per_course' => $studentsPerCourse,
            'recent_students' => Student::with('course')->latest()->take(6)->get(),
        ];

        return view('dashboard', $data);
    }
}

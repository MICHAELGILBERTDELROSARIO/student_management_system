<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $data = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'average_final_grade' => Grade::avg('final_grade'),
            'recent_students' => Student::with('course')->latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with('student.course', 'subject.course')->latest()->paginate(10);
        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::with('course')->get();
        $subjects = Subject::with('course')->get();
        return view('grades.create', compact('students', 'subjects'));
    }

    public function store(StoreGradeRequest $request)
    {
        Grade::create($request->validated());
        return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
    }

    public function show(Grade $grade)
    {
        $grade->load('student.course', 'subject.course');
        return view('grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        $students = Student::with('course')->get();
        $subjects = Subject::with('course')->get();
        return view('grades.edit', compact('grade', 'students', 'subjects'));
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade->update($request->validated());
        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <p class="card-text display-4">{{ $total_students }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Courses</h5>
                    <p class="card-text display-4">{{ $total_courses }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Average Final Grade</h5>
                    <p class="card-text display-4">{{ $average_final_grade ? number_format($average_final_grade, 2) : '0.00' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Recent Students</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Gender</th>
                            <th>Birth Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_students as $student)
                            <tr>
                                <td>{{ $student->student_number }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->course->course_name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($student->gender) }}</td>
                                <td>{{ $student->birth_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

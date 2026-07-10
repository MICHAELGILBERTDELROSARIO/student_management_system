@extends('layouts.app')

@section('title', 'Grades')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Grades</h1>
        <a href="{{ route('grades.create') }}" class="btn btn-primary">Add Grade</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Subject</th>
                            <th>1st Grading</th>
                            <th>2nd Grading</th>
                            <th>3rd Grading</th>
                            <th>4th Grading</th>
                            <th>Final Grade</th>
                            <th>Result</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $grade)
                            <tr>
                                <td>{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                                <td>{{ $grade->student->course->course_name ?? 'N/A' }}</td>
                                <td>{{ $grade->subject->subject_name ?? 'N/A' }}</td>
                                <td>{{ $grade->first_grading }}</td>
                                <td>{{ $grade->second_grading }}</td>
                                <td>{{ $grade->third_grading }}</td>
                                <td>{{ $grade->fourth_grading }}</td>
                                <td>{{ $grade->final_grade }}</td>
                                <td>
                                    <span class="badge {{ $grade->result == 'PASS' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $grade->result }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No grades found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $grades->links() }}
        </div>
    </div>
@endsection

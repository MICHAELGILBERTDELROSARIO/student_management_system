@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Students</h1>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
    </div>

    <form action="{{ route('students.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search students..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
            @if($search ?? false)
                <a href="{{ route('students.index') }}" class="btn btn-outline-danger">Clear</a>
            @endif
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Birth Date</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $student->student_number }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ ucfirst($student->gender) }}</td>
                                <td>{{ $student->birth_date }}</td>
                                <td>{{ $student->course->course_name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $students->links() }}
        </div>
    </div>
@endsection

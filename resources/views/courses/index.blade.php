@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Courses</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">Add Course</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Students Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td>{{ $course->course_code }}</td>
                                <td>{{ $course->course_name }}</td>
                                <td>{{ $course->students->count() }}</td>
                                <td>
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No courses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $courses->links() }}
        </div>
    </div>
@endsection

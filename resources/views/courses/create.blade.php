@extends('layouts.app')

@section('title', 'Add Course')

@section('content')
    <h1 class="mb-4">Add Course</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="course_code" class="form-label">Course Code</label>
                    <input type="text" class="form-control @error('course_code') is-invalid @enderror" id="course_code" name="course_code" value="{{ old('course_code') }}" required>
                    @error('course_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name</label>
                    <input type="text" class="form-control @error('course_name') is-invalid @enderror" id="course_name" name="course_name" value="{{ old('course_name') }}" required>
                    @error('course_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

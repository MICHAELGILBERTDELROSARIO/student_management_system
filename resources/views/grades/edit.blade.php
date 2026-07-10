@extends('layouts.app')

@section('title', 'Edit Grade')

@section('content')
    <h1 class="mb-4">Edit Grade</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('grades.update', $grade) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="student_id" class="form-label">Student</label>
                    <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ (old('student_id', $grade->student_id) == $student->id) ? 'selected' : '' }}>
                                {{ $student->student_number }} - {{ $student->first_name }} {{ $student->last_name }} ({{ $student->course->course_code ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ (old('subject_id', $grade->subject_id) == $subject->id) ? 'selected' : '' }}>
                                {{ $subject->subject_name }} ({{ $subject->courses->pluck('course_code')->join(', ') ?: 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="first_grading" class="form-label">First Grading</label>
                        <input type="number" step="0.01" class="form-control @error('first_grading') is-invalid @enderror" id="first_grading" name="first_grading" value="{{ old('first_grading', $grade->first_grading) }}" required>
                        @error('first_grading')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="second_grading" class="form-label">Second Grading</label>
                        <input type="number" step="0.01" class="form-control @error('second_grading') is-invalid @enderror" id="second_grading" name="second_grading" value="{{ old('second_grading', $grade->second_grading) }}" required>
                        @error('second_grading')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="third_grading" class="form-label">Third Grading</label>
                        <input type="number" step="0.01" class="form-control @error('third_grading') is-invalid @enderror" id="third_grading" name="third_grading" value="{{ old('third_grading', $grade->third_grading) }}" required>
                        @error('third_grading')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fourth_grading" class="form-label">Fourth Grading</label>
                        <input type="number" step="0.01" class="form-control @error('fourth_grading') is-invalid @enderror" id="fourth_grading" name="fourth_grading" value="{{ old('fourth_grading', $grade->fourth_grading) }}" required>
                        @error('fourth_grading')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

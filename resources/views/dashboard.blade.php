@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your institution')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="icon" style="background:#4f46e5;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="label">Total Students</div>
                <div class="value">{{ $total_students }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="icon" style="background:#0ea5e9;">
                    <i class="bi bi-book-half"></i>
                </div>
                <div class="label">Total Courses</div>
                <div class="value">{{ $total_courses }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="icon" style="background:#f59e0b;">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <div class="label">Total Subjects</div>
                <div class="value">{{ $total_subjects }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="icon" style="background:#10b981;">
                    <i class="bi bi-clipboard-data-fill"></i>
                </div>
                <div class="label">Average Grade</div>
                <div class="value">{{ $average_final_grade ? number_format($average_final_grade, 2) : '0.00' }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-xl-8">
            <div class="panel h-100">
                <div class="panel-head">
                    <h6>Students per Course</h6>
                    <span class="text-muted small">Distribution</span>
                </div>
                <div class="panel-body">
                    <canvas id="courseChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="panel h-100">
                <div class="panel-head">
                    <h6>Grade Results</h6>
                </div>
                <div class="panel-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span><span class="badge badge-pass">PASS</span> Passed</span>
                        <strong>{{ $passed_grades }}</strong>
                    </div>
                    <div class="progress mb-3" style="height:10px;">
                        <div class="progress-bar bg-success"
                             style="width:{{ $passed_grades + $failed_grades ? round($passed_grades / ($passed_grades + $failed_grades) * 100) : 0 }}%"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span><span class="badge badge-fail">FAIL</span> Failed</span>
                        <strong>{{ $failed_grades }}</strong>
                    </div>
                    <div class="progress" style="height:10px;">
                        <div class="progress-bar bg-danger"
                             style="width:{{ $passed_grades + $failed_grades ? round($failed_grades / ($passed_grades + $failed_grades) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <h6>Recent Students</h6>
            <a href="{{ route('students.index') }}" class="btn btn-sm btn-light border">View all</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Student</th>
                        <th>Student Number</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Gender</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_students as $student)
                        <tr>
                            <td>
                                <div class="student-name">
                                    <div class="student-initials">
                                        {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $student->first_name }} {{ $student->last_name }}</div>
                                        <div class="small text-muted">{{ $student->birth_date }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->student_number }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->course->course_name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($student->gender) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const courseData = @json($students_per_course->map(fn ($c) => [
            'label' => $c->course_code,
            'value' => $c->students_count,
        ]));

        new Chart(document.getElementById('courseChart'), {
            type: 'bar',
            data: {
                labels: courseData.map(c => c.label),
                datasets: [{
                    label: 'Students',
                    data: courseData.map(c => c.value),
                    backgroundColor: '#4f46e5',
                    borderRadius: 6,
                    maxBarThickness: 48,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
@endsection

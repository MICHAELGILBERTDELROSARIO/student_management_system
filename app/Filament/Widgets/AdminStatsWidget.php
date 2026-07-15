<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends BaseStatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalTeachers = Teacher::count();
        $totalSubjects = Subject::count();
        $averageGrade = Grade::avg('final_grade');
        $attendanceRate = Attendance::where('status', 'present')->count() / max(Attendance::count(), 1) * 100;

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('All enrolled students')
                ->icon('heroicon-o-users'),
            Stat::make('Total Courses', $totalCourses)
                ->description('Active courses')
                ->icon('heroicon-o-book-open'),
            Stat::make('Total Teachers', $totalTeachers)
                ->description('Faculty members')
                ->icon('heroicon-o-user-group'),
            Stat::make('Average Grade', number_format($averageGrade ?? 0, 2))
                ->description('Across all subjects')
                ->icon('heroicon-o-chart-bar'),
            Stat::make('Attendance Rate', number_format($attendanceRate, 1) . '%')
                ->description('Overall attendance')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Total Subjects', $totalSubjects)
                ->description('Active subjects')
                ->icon('heroicon-o-academic-cap'),
        ];
    }
}

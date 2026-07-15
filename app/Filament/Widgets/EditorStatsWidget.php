<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EditorStatsWidget extends BaseStatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $totalStudents = Student::count();
        $totalSubjects = Subject::count();
        $totalGrades = Grade::count();
        $totalAttendance = Attendance::count();

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('All enrolled students')
                ->icon('heroicon-o-users'),
            Stat::make('Total Subjects', $totalSubjects)
                ->description('Active subjects')
                ->icon('heroicon-o-book-open'),
            Stat::make('Total Grades', $totalGrades)
                ->description('Grade records')
                ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Total Attendance', $totalAttendance)
                ->description('Attendance records')
                ->icon('heroicon-o-calendar'),
        ];
    }
}

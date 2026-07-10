<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $passed = Grade::where('result', 'PASS')->count();
        $failed = Grade::where('result', 'FAIL')->count();
        $totalGrades = $passed + $failed;
        $passRate = $totalGrades ? round($passed / $totalGrades * 100) : 0;

        return [
            Stat::make('Total Students', Student::count())
                ->description('Enrolled learners')
                ->descriptionIcon('heroicon-m-users')
                ->icon('heroicon-o-users')
                ->color('success'),

            Stat::make('Total Courses', Course::count())
                ->description('Active programs')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->icon('heroicon-o-academic-cap')
                ->color('info'),

            Stat::make('Total Subjects', Subject::count())
                ->description('Across all courses')
                ->descriptionIcon('heroicon-m-book-open')
                ->icon('heroicon-o-book-open')
                ->color('warning'),

            Stat::make('Average Final Grade', number_format(Grade::avg('final_grade') ?? 0, 2))
                ->description('Class average')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->icon('heroicon-o-chart-bar')
                ->color('primary'),

            Stat::make('Pass Rate', $passRate . '%')
                ->description("$passed passed / $failed failed")
                ->descriptionIcon('heroicon-m-check-badge')
                ->icon('heroicon-o-check-circle')
                ->color($passRate >= 50 ? 'success' : 'danger'),

            Stat::make('Total Grades', Grade::count())
                ->description('Recorded assessments')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('gray'),
        ];
    }
}

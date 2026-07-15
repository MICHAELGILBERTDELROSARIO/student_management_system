<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStatsWidget extends BaseStatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $user = auth()->user();
        $student = $user->student;

        $myGrades = $student ? $student->grades()->count() : 0;
        $myAttendance = $student ? $student->attendances()->count() : 0;
        $myCourses = $student ? $student->course?->course_name : 'Not enrolled';

        return [
            Stat::make('My Courses', $myCourses)
                ->description('Current enrollment')
                ->icon('heroicon-o-book-open'),
            Stat::make('My Grades', $myGrades)
                ->description('Grade records')
                ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('My Attendance', $myAttendance)
                ->description('Attendance records')
                ->icon('heroicon-o-calendar'),
        ];
    }
}

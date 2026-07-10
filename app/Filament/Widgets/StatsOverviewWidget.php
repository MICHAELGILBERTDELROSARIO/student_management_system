<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::count())
                ->icon('heroicon-o-users')
                ->color('success'),

            Stat::make('Total Courses', Course::count())
                ->icon('heroicon-o-academic-cap')
                ->color('info'),

            Stat::make('Average Final Grade', number_format(Grade::avg('final_grade') ?? 0, 2))
                ->icon('heroicon-o-chart-bar')
                ->color('warning'),

            Stat::make('Total Grades', Grade::count())
                ->icon('heroicon-o-clipboard-document-list')
                ->color('primary'),
        ];
    }
}

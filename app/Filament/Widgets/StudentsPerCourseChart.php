<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Widgets\ChartWidget;

class StudentsPerCourseChart extends ChartWidget
{
    protected ?string $heading = 'Students per Course';

    protected ?string $pollingInterval = null;

    protected int | string | array $columnSpan = 1;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $courses = Course::withCount('students')
            ->orderBy('course_name')
            ->get();

        return [
            'labels' => $courses->pluck('course_code')->toArray(),
            'datasets' => [
                [
                    'label' => 'Students',
                    'data' => $courses->pluck('students_count')->toArray(),
                    'backgroundColor' => '#6366f1',
                    'borderRadius' => 6,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]],
                'x' => ['grid' => ['display' => false]],
            ],
        ];
    }
}

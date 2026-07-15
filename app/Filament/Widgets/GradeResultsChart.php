<?php

namespace App\Filament\Widgets;

use App\Models\Grade;
use Filament\Widgets\ChartWidget;

class GradeResultsChart extends ChartWidget
{
    protected ?string $heading = 'Grade Results';

    protected ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $passed = Grade::where('result', 'PASS')->count();
        $failed = Grade::where('result', 'FAIL')->count();

        return [
            'labels' => ['Passed', 'Failed'],
            'datasets' => [
                [
                    'data' => [$passed, $failed],
                    'backgroundColor' => ['#22c55e', '#ef4444'],
                    'borderWidth' => 0,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'cutout' => '65%',
            'plugins' => [
                'legend' => ['position' => 'bottom'],
            ],
        ];
    }
}

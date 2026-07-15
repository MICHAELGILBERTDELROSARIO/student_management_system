<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $slug = '';

    protected static ?int $navigationSort = -2;

    public static function getRoutePath(\Filament\Panel $panel): string
    {
        return '/';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function getWidgets(): array
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return [
                \App\Filament\Widgets\AdminStatsWidget::class,
                \App\Filament\Widgets\GradesPerCourseTableWidget::class,
                \App\Filament\Widgets\RecentStudentsTableWidget::class,
            ];
        }

        if ($user->isEditor()) {
            return [
                \App\Filament\Widgets\EditorStatsWidget::class,
                \App\Filament\Widgets\RecentGradesTableWidget::class,
            ];
        }

        return [
            \App\Filament\Widgets\StudentStatsWidget::class,
            \App\Filament\Widgets\StudentGradesTableWidget::class,
            \App\Filament\Widgets\StudentAttendanceTableWidget::class,
        ];
    }
}

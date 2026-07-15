<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminStatsWidget;
use App\Filament\Widgets\EditorStatsWidget;
use App\Filament\Widgets\GradesPerCourseTableWidget;
use App\Filament\Widgets\RecentGradesTableWidget;
use App\Filament\Widgets\RecentStudentsTableWidget;
use App\Filament\Widgets\StudentAttendanceTableWidget;
use App\Filament\Widgets\StudentGradesTableWidget;
use App\Filament\Widgets\StudentStatsWidget;
use BackedEnum;
use Filament\Panel;
use Filament\Support\Icons\Heroicon;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $slug = '';

    protected static ?int $navigationSort = -2;

    public static function getRoutePath(Panel $panel): string
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
                AdminStatsWidget::class,
                GradesPerCourseTableWidget::class,
                RecentStudentsTableWidget::class,
            ];
        }

        if ($user->isEditor()) {
            return [
                EditorStatsWidget::class,
                RecentGradesTableWidget::class,
            ];
        }

        return [
            StudentStatsWidget::class,
            StudentGradesTableWidget::class,
            StudentAttendanceTableWidget::class,
        ];
    }

    public function getPageClasses(): array
    {
        return [
            'page-dashboard',
        ];
    }
}

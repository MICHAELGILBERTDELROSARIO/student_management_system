<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Reports;
use App\Filament\Resources\Attendances\AttendanceResource;
use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Grades\GradeResource;
use App\Filament\Resources\Students\StudentResource;
use App\Filament\Resources\Subjects\SubjectResource;
use App\Filament\Resources\Teachers\TeacherResource;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Widgets\AccountWidget;
use App\Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\GradeResultsChart;
use App\Filament\Widgets\RecentStudentsTableWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\StudentsPerCourseChart;
use App\Http\Middleware\SetFilamentBrandName;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->maxContentWidth(Width::Full)
            ->assets([
                Css::make('dashboard-gradient')->relativePublicPath('css/dashboard-gradient.css'),
                Css::make('admin-design')->relativePublicPath('css/admin-design.css'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                Reports::class,
            ])
            ->navigation(function () {
                $user = auth()->user();

                if (! $user) {
                    return true;
                }

                $builder = new NavigationBuilder;

                if ($user->isAdmin()) {
                    $builder->groups([
                        NavigationGroup::make('Management')
                            ->items([
                                NavigationItem::make('Dashboard')
                                    ->icon('heroicon-o-home')
                                    ->activeIcon('heroicon-s-home')
                                    ->url(Dashboard::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                    ->sort(-2),
                                NavigationItem::make('Students')
                                    ->icon('heroicon-o-users')
                                    ->activeIcon('heroicon-s-users')
                                    ->url(fn (): string => StudentResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.students.*'))
                                    ->sort(1),
                                NavigationItem::make('Courses')
                                    ->icon('heroicon-o-book-open')
                                    ->activeIcon('heroicon-s-book-open')
                                    ->url(fn (): string => CourseResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.courses.*'))
                                    ->sort(2),
                                NavigationItem::make('Grades')
                                    ->icon('heroicon-o-clipboard-document-list')
                                    ->activeIcon('heroicon-s-clipboard-document-list')
                                    ->url(fn (): string => GradeResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.grades.*'))
                                    ->sort(3),
                                NavigationItem::make('Attendance')
                                    ->icon('heroicon-o-calendar')
                                    ->activeIcon('heroicon-s-calendar')
                                    ->url(fn (): string => AttendanceResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.attendances.*'))
                                    ->sort(4),
                                NavigationItem::make('Teachers')
                                    ->icon('heroicon-o-user-group')
                                    ->activeIcon('heroicon-s-user-group')
                                    ->url(fn (): string => TeacherResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.teachers.*'))
                                    ->sort(5),
                                NavigationItem::make('Subjects')
                                    ->icon('heroicon-o-academic-cap')
                                    ->activeIcon('heroicon-s-academic-cap')
                                    ->url(fn (): string => SubjectResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.subjects.*'))
                                    ->sort(6),
                            ]),
                        NavigationGroup::make('System')
                            ->items([
                                NavigationItem::make('Users')
                                    ->icon('heroicon-o-user')
                                    ->activeIcon('heroicon-s-user')
                                    ->url(fn (): string => UserResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.users.*'))
                                    ->sort(7),
                                NavigationItem::make('Reports')
                                    ->icon('heroicon-o-chart-bar')
                                    ->activeIcon('heroicon-s-chart-bar')
                                    ->url(fn (): string => Reports::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.reports'))
                                    ->sort(8),
                            ]),
                    ]);

                    return $builder;
                }

                if ($user->isEditor()) {
                    $builder->groups([
                        NavigationGroup::make('Management')
                            ->items([
                                NavigationItem::make('Dashboard')
                                    ->icon('heroicon-o-home')
                                    ->activeIcon('heroicon-s-home')
                                    ->url(Dashboard::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                    ->sort(-2),
                                NavigationItem::make('Students')
                                    ->icon('heroicon-o-users')
                                    ->activeIcon('heroicon-s-users')
                                    ->url(fn (): string => StudentResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.students.*'))
                                    ->sort(1),
                                NavigationItem::make('Grades')
                                    ->icon('heroicon-o-clipboard-document-list')
                                    ->activeIcon('heroicon-s-clipboard-document-list')
                                    ->url(fn (): string => GradeResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.grades.*'))
                                    ->sort(2),
                                NavigationItem::make('Attendance')
                                    ->icon('heroicon-o-calendar')
                                    ->activeIcon('heroicon-s-calendar')
                                    ->url(fn (): string => AttendanceResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.attendances.*'))
                                    ->sort(3),
                            ]),
                        NavigationGroup::make('System')
                            ->items([
                                NavigationItem::make('Reports')
                                    ->icon('heroicon-o-chart-bar')
                                    ->activeIcon('heroicon-s-chart-bar')
                                    ->url(fn (): string => Reports::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.reports'))
                                    ->sort(4),
                            ]),
                    ]);

                    return $builder;
                }

                if ($user->isStudent()) {
                    $builder->groups([
                        NavigationGroup::make('Student')
                            ->items([
                                NavigationItem::make('My Dashboard')
                                    ->icon('heroicon-o-home')
                                    ->activeIcon('heroicon-s-home')
                                    ->url(Dashboard::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                    ->sort(-2),
                            ]),
                    ]);

                    return $builder;
                }

                return true;
            })
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                StatsOverviewWidget::class,
                StudentsPerCourseChart::class,
                GradeResultsChart::class,
                RecentStudentsTableWidget::class,
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetFilamentBrandName::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

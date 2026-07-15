<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Reports;
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
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
                'primary' => Color::Indigo,
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

                $builder = new \Filament\Navigation\NavigationBuilder();

                if ($user->isAdmin()) {
                    $builder->groups([
                        \Filament\Navigation\NavigationGroup::make('Management')
                            ->items([
                                \Filament\Navigation\NavigationItem::make('Dashboard')
                                    ->icon('heroicon-o-home')
                                    ->activeIcon('heroicon-s-home')
                                    ->url(Dashboard::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                    ->sort(-2),
                                \Filament\Navigation\NavigationItem::make('Students')
                                    ->icon('heroicon-o-users')
                                    ->activeIcon('heroicon-s-users')
                                    ->url(fn (): string => \App\Filament\Resources\Students\StudentResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.students.*'))
                                    ->sort(1),
                                \Filament\Navigation\NavigationItem::make('Courses')
                                    ->icon('heroicon-o-book-open')
                                    ->activeIcon('heroicon-s-book-open')
                                    ->url(fn (): string => \App\Filament\Resources\Courses\CourseResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.courses.*'))
                                    ->sort(2),
                                \Filament\Navigation\NavigationItem::make('Grades')
                                    ->icon('heroicon-o-clipboard-document-list')
                                    ->activeIcon('heroicon-s-clipboard-document-list')
                                    ->url(fn (): string => \App\Filament\Resources\Grades\GradeResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.grades.*'))
                                    ->sort(3),
                                \Filament\Navigation\NavigationItem::make('Attendance')
                                    ->icon('heroicon-o-calendar')
                                    ->activeIcon('heroicon-s-calendar')
                                    ->url(fn (): string => \App\Filament\Resources\Attendances\AttendanceResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.attendances.*'))
                                    ->sort(4),
                                \Filament\Navigation\NavigationItem::make('Teachers')
                                    ->icon('heroicon-o-user-group')
                                    ->activeIcon('heroicon-s-user-group')
                                    ->url(fn (): string => \App\Filament\Resources\Teachers\TeacherResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.teachers.*'))
                                    ->sort(5),
                                \Filament\Navigation\NavigationItem::make('Subjects')
                                    ->icon('heroicon-o-academic-cap')
                                    ->activeIcon('heroicon-s-academic-cap')
                                    ->url(fn (): string => \App\Filament\Resources\Subjects\SubjectResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.subjects.*'))
                                    ->sort(6),
                            ]),
                        \Filament\Navigation\NavigationGroup::make('System')
                            ->items([
                                \Filament\Navigation\NavigationItem::make('Users')
                                    ->icon('heroicon-o-user')
                                    ->activeIcon('heroicon-s-user')
                                    ->url(fn (): string => \App\Filament\Resources\Users\UserResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.users.*'))
                                    ->sort(7),
                                \Filament\Navigation\NavigationItem::make('Reports')
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
                        \Filament\Navigation\NavigationGroup::make('Management')
                            ->items([
                                \Filament\Navigation\NavigationItem::make('Dashboard')
                                    ->icon('heroicon-o-home')
                                    ->activeIcon('heroicon-s-home')
                                    ->url(Dashboard::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                    ->sort(-2),
                                \Filament\Navigation\NavigationItem::make('Students')
                                    ->icon('heroicon-o-users')
                                    ->activeIcon('heroicon-s-users')
                                    ->url(fn (): string => \App\Filament\Resources\Students\StudentResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.students.*'))
                                    ->sort(1),
                                \Filament\Navigation\NavigationItem::make('Grades')
                                    ->icon('heroicon-o-clipboard-document-list')
                                    ->activeIcon('heroicon-s-clipboard-document-list')
                                    ->url(fn (): string => \App\Filament\Resources\Grades\GradeResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.grades.*'))
                                    ->sort(2),
                                \Filament\Navigation\NavigationItem::make('Attendance')
                                    ->icon('heroicon-o-calendar')
                                    ->activeIcon('heroicon-s-calendar')
                                    ->url(fn (): string => \App\Filament\Resources\Attendances\AttendanceResource::getUrl())
                                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.attendances.*'))
                                    ->sort(3),
                            ]),
                        \Filament\Navigation\NavigationGroup::make('System')
                            ->items([
                                \Filament\Navigation\NavigationItem::make('Reports')
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
                        \Filament\Navigation\NavigationGroup::make('Student')
                            ->items([
                                \Filament\Navigation\NavigationItem::make('My Dashboard')
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

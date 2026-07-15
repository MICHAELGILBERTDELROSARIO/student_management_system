<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class Reports extends Page
{
    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'Reports';

    protected static ?string $slug = 'reports';

    protected static ?int $navigationSort = 99;

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        if ($user->isAdmin() || $user->isEditor()) {
            return true;
        }

        return $user->can('view reports');
    }

    public function getStats(): array
    {
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $averageGrade = Grade::avg('final_grade');
        $attendanceRate = Attendance::where('status', 'present')->count() / max(Attendance::count(), 1) * 100;

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('All enrolled students')
                ->icon('heroicon-o-users'),
            Stat::make('Total Courses', $totalCourses)
                ->description('Active courses')
                ->icon('heroicon-o-book-open'),
            Stat::make('Average Grade', number_format($averageGrade ?? 0, 2))
                ->description('Across all subjects')
                ->icon('heroicon-o-chart-bar'),
            Stat::make('Attendance Rate', number_format($attendanceRate, 1) . '%')
                ->description('Overall attendance')
                ->icon('heroicon-o-check-circle'),
        ];
    }

    public function getGradesPerCourseProperty()
    {
        return Course::withCount('students')
            ->withAvg('grades', 'final_grade')
            ->get()
            ->map(fn ($course) => [
                'label' => $course->course_code,
                'students' => $course->students_count,
                'avg_grade' => round($course->grades_avg_final_grade ?? 0, 2),
            ]);
    }

    public function getAttendanceByStatusProperty()
    {
        return Attendance::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->status => $item->count]);
    }

    public function content(Schema $schema): Schema
    {
        $stats = $this->getStats();

        $gradesPerCourse = $this->getGradesPerCourseProperty()->map(
            fn (array $course) => Grid::make(3)
                ->schema([
                    Text::make($course['label']),
                    Text::make((string) $course['students'] . ' students'),
                    Text::make('Avg: ' . $course['avg_grade']),
                ])
        )->toArray();

        $attendanceByStatus = $this->getAttendanceByStatusProperty()->map(
            fn (string $count, string $status) => Grid::make(2)
                ->schema([
                    Text::make(ucfirst($status)),
                    Text::make((string) $count),
                ])
        )->toArray();

        return $schema->components([
            Section::make('Stats')
                ->schema([
                    Grid::make(4)
                        ->schema(
                            collect($stats)->map(
                                fn (Stat $stat) => Flex::make()
                                    ->schema([
                                        Text::make((string) $stat->getValue()),
                                        Text::make($stat->getLabel()),
                                    ])
                            )->toArray()
                        ),
                ]),
            Section::make('Grades Per Course')
                ->schema([
                    Grid::make(1)
                        ->schema($gradesPerCourse),
                ]),
            Section::make('Attendance by Status')
                ->schema([
                    Grid::make(1)
                        ->schema($attendanceByStatus),
                ]),
        ]);
    }
}

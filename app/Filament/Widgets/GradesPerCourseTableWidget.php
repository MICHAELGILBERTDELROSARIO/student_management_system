<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Grade;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;

class GradesPerCourseTableWidget extends BaseTableWidget
{
    protected static ?string $heading = 'Grades Per Course';

    protected int | string | array $span = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Course::query()
                    ->withCount('students')
                    ->withAvg('grades', 'final_grade')
                    ->orderBy('course_code'),
            )
            ->columns([
                TextColumn::make('course_code')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('students_count')
                    ->label('Students')
                    ->sortable(),
                TextColumn::make('grades_avg_final_grade')
                    ->label('Average Grade')
                    ->getStateUsing(fn (Course $course): string => number_format($course->grades_avg_final_grade ?? 0, 2))
                    ->sortable(),
            ]);
    }
}

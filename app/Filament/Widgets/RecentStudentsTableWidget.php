<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;

class RecentStudentsTableWidget extends BaseTableWidget
{
    protected static ?string $heading = 'Recent Students';

    protected int|string|array $span = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Student::query()
                    ->with('course')
                    ->latest()
                    ->take(5),
            )
            ->columns([
                TextColumn::make('student_number')
                    ->label('Student #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.course_name')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
            ]);
    }
}

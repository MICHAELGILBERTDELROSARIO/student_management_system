<?php

namespace App\Filament\Widgets;

use App\Models\Grade;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;

class RecentGradesTableWidget extends BaseTableWidget
{
    protected static ?string $heading = 'Recent Grades';

    protected int | string | array $span = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Grade::query()
                    ->with('student', 'subject')
                    ->latest()
                    ->take(5),
            )
            ->columns([
                TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject.subject_name')
                    ->label('Subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('final_grade')
                    ->label('Final Grade')
                    ->sortable(),
                TextColumn::make('result')
                    ->label('Result')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PASS' => 'success',
                        'FAIL' => 'danger',
                    }),
            ]);
    }
}

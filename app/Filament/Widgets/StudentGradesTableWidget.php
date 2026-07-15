<?php

namespace App\Filament\Widgets;

use App\Models\Grade;
use App\Models\Student;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;

class StudentGradesTableWidget extends BaseTableWidget
{
    protected static ?string $heading = 'My Grades';

    protected int | string | array $span = 'full';

    public function table(Table $table): Table
    {
        $user = auth()->user();
        $student = Student::where('email', $user->email)->first();

        if (! $student) {
            return $table->query(Grade::where('id', 0))->columns([]);
        }

        return $table
            ->query(
                Grade::query()
                    ->with('subject')
                    ->where('student_id', $student->id)
                    ->latest(),
            )
            ->columns([
                TextColumn::make('subject.subject_name')
                    ->label('Subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('final_grade')
                    ->label('Final Grade')
                    ->sortable(),
                BadgeColumn::make('result')
                    ->label('Result')
                    ->color(fn (string $state): string => match ($state) {
                        'PASS' => 'success',
                        'FAIL' => 'danger',
                    }),
            ]);
    }
}

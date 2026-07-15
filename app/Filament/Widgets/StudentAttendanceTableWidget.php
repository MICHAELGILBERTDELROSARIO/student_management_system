<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Student;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;

class StudentAttendanceTableWidget extends BaseTableWidget
{
    protected static ?string $heading = 'Recent Attendance';

    protected int | string | array $span = 'full';

    public function table(Table $table): Table
    {
        $user = auth()->user();
        $student = Student::where('email', $user->email)->first();

        if (! $student) {
            return $table->query(Attendance::where('id', 0))->columns([]);
        }

        return $table
            ->query(
                Attendance::query()
                    ->with('subject')
                    ->where('student_id', $student->id)
                    ->latest()
                    ->take(10),
            )
            ->columns([
                TextColumn::make('subject.subject_name')
                    ->label('Subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ]);
    }
}

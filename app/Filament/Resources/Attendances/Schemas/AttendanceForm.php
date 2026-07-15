<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required(),
                Select::make('subject_id')
                    ->relationship('subject', 'subject_name')
                    ->required(),
                TextInput::make('date')
                    ->date()
                    ->required(),
                Select::make('status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'late' => 'Late',
                    ])
                    ->required(),
                Textarea::make('remarks')
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }
}

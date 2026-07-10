<?php

namespace App\Filament\Resources\Grades\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'student_number')
                    ->required(),
                Select::make('subject_id')
                    ->relationship('subject', 'subject_name')
                    ->required(),
                TextInput::make('first_grading')
                    ->numeric()
                    ->required(),
                TextInput::make('second_grading')
                    ->numeric()
                    ->required(),
                TextInput::make('third_grading')
                    ->numeric()
                    ->required(),
                TextInput::make('fourth_grading')
                    ->numeric()
                    ->required(),
                TextInput::make('final_grade')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('result')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }
}

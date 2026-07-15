<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Student;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User account')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('student_number')
                    ->required()
                    ->unique(Student::class, ignoreRecord: true)
                    ->validationAttribute('student number'),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                Select::make('gender')
                    ->options(['male' => 'Male', 'female' => 'Female'])
                    ->required(),
                DatePicker::make('birth_date')
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'course_name')
                    ->required(),
            ]);
    }
}

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
                TextInput::make('student_number')
                    ->required()
                    ->unique(Student::class, ignoreRecord: true)
                    ->validationAttribute('student number')
                    ->default(function () {
                        $year = now()->year;
                        $lastStudent = Student::where('student_number', 'like', "{$year}-%")
                            ->orderBy('student_number', 'desc')
                            ->first();

                        $lastNumber = $lastStudent
                            ? (int) str_replace("{$year}-", '', $lastStudent->student_number)
                            : 0;

                        return sprintf('%s-%03d', $year, $lastNumber + 1);
                    })
                    ->readOnly(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn (callable $get) => ! $get('student_number') || Student::where('student_number', $get('student_number'))->exists()),
                Select::make('gender')
                    ->options(['male' => 'Male', 'female' => 'Female'])
                    ->required(),
                DatePicker::make('birth_date')
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'course_name')
                    ->required(),
                TextInput::make('year_level')
                    ->required(),
            ]);
    }
}

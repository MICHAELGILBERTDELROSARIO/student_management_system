<?php

namespace App\Filament\Resources\Subjects\Schemas;

use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                MultiSelect::make('courses')
                    ->relationship('courses', 'course_name')
                    ->placeholder('Select one or more courses')
                    ->preload()
                    ->searchable()
                    ->required(),
                TextInput::make('subject_name')
                    ->required(),
            ]);
    }
}

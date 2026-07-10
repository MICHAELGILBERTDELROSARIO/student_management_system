<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('course_code')
                    ->required(),
                TextInput::make('course_name')
                    ->required(),
            ]);
    }
}

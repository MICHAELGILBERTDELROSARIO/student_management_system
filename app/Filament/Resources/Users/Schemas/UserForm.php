<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Student;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->visible(fn (callable $get) => $get('role') !== User::ROLE_STUDENT || empty($get('student_id'))),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->nullable()
                    ->helperText('Leave blank to keep the current password.'),
                Select::make('role')
                    ->label('Role')
                    ->options([
                        User::ROLE_ADMIN => 'Admin',
                        User::ROLE_EDITOR => 'Editor',
                        User::ROLE_STUDENT => 'Student',
                    ])
                    ->default(User::ROLE_ADMIN)
                    ->required(),
                Select::make('student_id')
                    ->label('Link to Student')
                    ->options(function (?User $user) {
                        $query = Student::query();

                        if ($user && $user->exists) {
                            $query->whereNull('user_id')->orWhere('user_id', $user->id);
                        } else {
                            $query->whereNull('user_id');
                        }

                        return $query->pluck('student_number', 'id');
                    })
                    ->searchable()
                    ->visible(fn (callable $get) => $get('role') === User::ROLE_STUDENT)
                    ->required(fn (callable $get) => $get('role') === User::ROLE_STUDENT),
            ]);
    }
}

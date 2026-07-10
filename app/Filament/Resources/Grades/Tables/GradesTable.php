<?php

namespace App\Filament\Resources\Grades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.student_number')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject.subject_name')
                    ->label('Subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_grading')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('second_grading')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('third_grading')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fourth_grading')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('final_grade')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('result')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

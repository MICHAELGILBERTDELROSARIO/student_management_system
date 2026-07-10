<?php

namespace App\Filament\Resources\Students\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GradesRelationManager extends RelationManager
{
    protected static string $relationship = 'grades';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
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
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

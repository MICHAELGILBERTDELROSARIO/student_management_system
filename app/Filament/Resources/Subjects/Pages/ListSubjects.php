<?php

namespace App\Filament\Resources\Subjects\Pages;

use App\Filament\Resources\Subjects\SubjectResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListSubjects extends ListRecords
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('bulk_create')
                ->label('Bulk Create')
                ->icon('heroicon-o-rectangle-stack')
                ->modalHeading('Bulk Create Subjects')
                ->modalDescription('Enter multiple subject names and assign them to one or more courses.')
                ->form([
                    \Filament\Forms\Components\Textarea::make('subjects')
                        ->label('Subject Names')
                        ->placeholder("Programming Fundamentals\nDatabase Management Systems\nWeb Development")
                        ->rows(12)
                        ->required()
                        ->helperText('Enter one subject per line.'),
                    \Filament\Forms\Components\CheckboxList::make('courses')
                        ->label('Courses')
                        ->options(\App\Models\Course::pluck('course_name', 'id')->toArray())
                        ->required()
                        ->columns(2)
                        ->helperText('Select one or more courses.'),
                ])
                ->action(function (array $data) {
                    $subjects = array_values(array_filter(array_map('trim', explode("\n", $data['subjects'])), fn ($s) => $s !== ''));

                    if (empty($subjects)) {
                        Notification::make()
                            ->title('Please enter at least one subject.')
                            ->danger()
                            ->send();
                        return;
                    }

                    if (empty($data['courses'])) {
                        Notification::make()
                            ->title('Please select at least one course.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $count = 0;

                    foreach ($data['courses'] as $courseId) {
                        foreach ($subjects as $subjectName) {
                            $subject = \App\Models\Subject::firstOrCreate(['subject_name' => $subjectName]);

                            if (! $subject->courses()->where('course_id', $courseId)->exists()) {
                                $subject->courses()->attach($courseId);
                                $count++;
                            }
                        }
                    }

                    if ($count > 0) {
                        Notification::make()
                            ->title("{$count} subject(s) created/assigned successfully.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('All subjects already exist for the selected courses.')
                            ->warning()
                            ->send();
                    }
                })
                ->color('success'),
            CreateAction::make(),
        ];
    }
}

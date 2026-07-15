<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Student;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        DB::transaction(function () {
            $this->record->syncRoles([$this->data['role']]);

            if ($this->data['role'] === User::ROLE_STUDENT && ! empty($this->data['student_id'])) {
                $student = Student::where('id', $this->data['student_id'])->first();

                if ($student) {
                    $this->record->update(['name' => $student->name]);
                    $student->update(['user_id' => $this->record->id]);
                }
            } elseif ($this->data['role'] !== User::ROLE_STUDENT) {
                $this->record->student()->update(['user_id' => null]);
            }
        });
    }
}

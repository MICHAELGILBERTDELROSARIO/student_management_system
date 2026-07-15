<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Student;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        if ($data['role'] === User::ROLE_STUDENT && ! empty($data['student_id'])) {
            $student = Student::where('id', $data['student_id'])->first();

            if ($student) {
                $data['name'] = $student->name;
            }
        }

        return DB::transaction(function () use ($data) {
            $record = parent::handleRecordCreation($data);
            $record->assignRole($data['role']);

            if ($data['role'] === User::ROLE_STUDENT && ! empty($data['student_id'])) {
                Student::where('id', $data['student_id'])->update(['user_id' => $record->id]);
            }

            return $record;
        });
    }
}

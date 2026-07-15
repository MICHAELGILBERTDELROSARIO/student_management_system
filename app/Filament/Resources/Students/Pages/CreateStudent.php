<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use App\Models\Student;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $studentNumber = $data['student_number'];
            $firstName = $data['first_name'];
            $lastName = $data['last_name'];

            $user = User::create([
                'name' => trim($firstName.' '.$lastName),
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => User::ROLE_STUDENT,
            ]);

            $user->assignRole('Student');

            $studentData = [
                'student_number' => $studentNumber,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'gender' => $data['gender'],
                'birth_date' => $data['birth_date'],
                'course_id' => $data['course_id'],
                'year_level' => $data['year_level'],
                'user_id' => $user->id,
            ];

            return Student::create($studentData);
        });
    }
}

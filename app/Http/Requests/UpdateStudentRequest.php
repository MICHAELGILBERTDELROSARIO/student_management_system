<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student');

        return [
            'student_number' => ['required', 'string', 'max:255', 'unique:students,student_number,' . $student->id],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,' . $student->id],
            'gender' => ['required', 'in:male,female'],
            'birth_date' => ['required', 'date'],
            'course_id' => ['required', 'exists:courses,id'],
        ];
    }
}

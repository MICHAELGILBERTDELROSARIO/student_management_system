<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $grade = $this->route('grade');

        return [
            'student_id' => ['required', 'exists:students,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'first_grading' => ['required', 'numeric', 'min:0', 'max:100'],
            'second_grading' => ['required', 'numeric', 'min:0', 'max:100'],
            'third_grading' => ['required', 'numeric', 'min:0', 'max:100'],
            'fourth_grading' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}

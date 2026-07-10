<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_code' => ['required', 'string', 'max:255', 'unique:courses,course_code'],
            'course_name' => ['required', 'string', 'max:255'],
        ];
    }
}

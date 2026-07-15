<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $course = $this->route('course');

        return [
            'course_code' => ['required', 'string', 'max:255', 'unique:courses,course_code,'.$course->id],
            'course_name' => ['required', 'string', 'max:255'],
        ];
    }
}

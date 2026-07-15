<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'first_grading',
        'second_grading',
        'third_grading',
        'fourth_grading',
        'final_grade',
        'result',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $grade) {
            $grade->final_grade = round((
                $grade->first_grading +
                $grade->second_grading +
                $grade->third_grading +
                $grade->fourth_grading
            ) / 4, 2);

            $grade->result = $grade->final_grade >= 75 ? 'PASS' : 'FAIL';
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function getTitleAttribute(): ?string
    {
        return $this->student
            ? $this->student->student_number.' - '.($this->subject->subject_name ?? 'No Subject')
            : null;
    }
}

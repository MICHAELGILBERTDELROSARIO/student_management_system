<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'course_id',
        'year_level',
        'user_id',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function getNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    protected static function booted(): void
    {
        static::creating(function (Student $student) {
            if (empty($student->student_number)) {
                $year = now()->year;

                DB::transaction(function () use ($student, $year) {
                    $lastStudent = static::where('student_number', 'like', "{$year}-%")
                        ->orderBy('student_number', 'desc')
                        ->lockForUpdate()
                        ->first();

                    $lastNumber = $lastStudent
                        ? (int) str_replace("{$year}-", '', $lastStudent->student_number)
                        : 0;

                    $student->student_number = sprintf('%s-%03d', $year, $lastNumber + 1);
                });
            }
        });
    }
}

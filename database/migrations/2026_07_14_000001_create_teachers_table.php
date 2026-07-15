<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('specialization')->nullable();
            $table->date('hire_date')->nullable();
            $table->timestamps();
        });

        Schema::create('course_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['course_id', 'teacher_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_teacher');
        Schema::dropIfExists('teachers');
    }
};

<?php

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Student::whereNull('user_id')->each(function (Student $student) {
            $name = $student->first_name.' '.$student->last_name;
            $email = strtolower($student->first_name.'.'.$student->last_name.'@student.local');

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => User::ROLE_STUDENT,
            ]);

            $student->update(['user_id' => $user->id]);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unique('user_id', 'students_user_id_unique');
            $table->foreign('user_id', 'students_user_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique('students_user_id_unique');
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id', 'students_user_id_foreign')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};

<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, '__invoke'])->name('dashboard');

Route::resource('courses', CourseController::class);
Route::resource('students', StudentController::class);
Route::resource('grades', GradeController::class);

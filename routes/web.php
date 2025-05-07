<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('staff', StaffController::class);
});

// Students
Route::get('/students/export/pdf', [StudentController::class, 'exportPdf'])->name('students.export.pdf');

require __DIR__ . '/auth.php';

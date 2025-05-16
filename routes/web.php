<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\InstructorPositionController;
use App\Http\Controllers\EnrollmentsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
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
    Route::resource('instructors', InstructorController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('terms', TermController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('intructor-positions', InstructorPositionController::class);
    Route::resource('enrollments', EnrollmentsController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('users', UserController::class);

    Route::get('/students/export/pdf', [StudentController::class, 'exportPdf'])->name('students.export.pdf');
    Route::get('/courses/export/pdf', [CourseController::class, 'exportPdf'])->name('courses.export.pdf');
    Route::get('/instructors/export/pdf', [InstructorController::class, 'exportPdf'])->name('instructors.export.pdf');
    Route::get('/departments/export/pdf', [DepartmentController::class, 'exportPdf'])->name('departments.export.pdf');
    Route::get('/programs/export/pdf', [ProgramController::class, 'exportPdf'])->name('programs.export.pdf');
    Route::get('/sections/export/pdf', [SectionController::class, 'exportPdf'])->name('sections.export.pdf');
    Route::get('/rooms/export/pdf', [RoomController::class, 'exportPdf'])->name('rooms.export.pdf');
    Route::get('/positions/export/pdf', [PositionController::class, 'exportPdf'])->name('positions.export.pdf');
    Route::get('/enrollments/export/pdf', [EnrollmentsController::class, 'exportPdf'])->name('enrollments.export.pdf');
    Route::get('/instructor-positions/export/pdf', [InstructorPositionController::class, 'exportPdf'])->name('instructor-positions.export.pdf');
    Route::get('/schedules/export/pdf', [ScheduleController::class, 'exportPdf'])->name('schedules.export.pdf');
    Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
});

// Students
require __DIR__ . '/auth.php';

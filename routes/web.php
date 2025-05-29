<?php

use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentSide\StudentEnrollmentsController;
use App\Http\Controllers\StudentSide\StudentProfileController;
use App\Http\Controllers\Instructor\InstructorDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Debug route to check authentication and role
Route::get('/check-auth', function () {
    if (Auth::check()) {
        return response()->json([
            'authenticated' => true,
            'user' => Auth::user(),
            'role' => Auth::user()->role
        ]);
    } else {
        return response()->json(['authenticated' => false]);
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard-redirect', function () {
        $user = Auth::user();
        if ($user->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'Instructor') {
            return redirect()->route('instructor.dashboard');
        }
        return redirect()->route('studentSide.dashboard');
    })->name('dashboard');

    Route::middleware('role:Admin')->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('students', StudentController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('instructors', InstructorController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('programs', ProgramController::class);
        Route::resource('sections', SectionController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('terms', TermController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('instructor-positions', InstructorPositionController::class);
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

        Route::get('/students/{student}/export-pdf', [StudentController::class, 'exportIndividualPdf'])->name('students.export.individual.pdf');
        Route::get('/courses/{course}/export-pdf', [CourseController::class, 'exportIndividualPdf'])->name('courses.export.individual.pdf');
        Route::get('/departments/{department}/export-pdf', [DepartmentController::class, 'exportIndividualPdf'])->name('departments.export.individual.pdf');
        Route::get('/instructors/{instructor}/export-pdf', [InstructorController::class, 'exportIndividualPdf'])->name('instructors.export.individual.pdf');
        Route::get('/enrollments/{enrollment}/export-pdf', [EnrollmentsController::class, 'exportIndividualPdf'])->name('enrollments.export.individual.pdf');
        Route::get('/instructor-positions/{instructorPosition}/export-pdf', [InstructorPositionController::class, 'exportIndividualPdf'])->name('instructor-positions.export.individual.pdf');
        Route::get('/positions/{position}/export-pdf', [PositionController::class, 'exportIndividualPdf'])->name('positions.export.individual.pdf');
        Route::get('/programs/{program}/export-pdf', [ProgramController::class, 'exportIndividualPdf'])->name('programs.export.individual.pdf');
        Route::get('/rooms/{room}/export-pdf', [RoomController::class, 'exportIndividualPdf'])->name('rooms.export.individual.pdf');
        Route::get('/sections/{section}/export-pdf', [SectionController::class, 'exportIndividualPdf'])->name('sections.export.individual.pdf');
        Route::get('/schedules/{schedule}/export-pdf', [ScheduleController::class, 'exportIndividualPdf'])->name('schedules.export.individual.pdf');
        Route::get('/terms/{term}/export-pdf', [TermController::class, 'exportIndividualPdf'])->name('terms.export.individual.pdf');

        Route::get('/enrollments/create/bulk', [EnrollmentsController::class, 'createBulk'])->name('enrollments.create.bulk');
        Route::post('/enrollments/store/bulk', [EnrollmentsController::class, 'storeBulk'])->name('enrollments.store.bulk');

        // Admin API Routes
        Route::get('/api/admin/courses-by-program', [EnrollmentsController::class, 'getCoursesByProgram']);
        Route::get('/api/admin/sections-by-program', [EnrollmentsController::class, 'getSectionsByProgram']);
        Route::get('/api/admin/schedules-by-course-section', [EnrollmentsController::class, 'getSchedulesByCourseAndSection']);

        Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
        Route::get('/api/dashboard/enrollment-trend', [DashboardController::class, 'getEnrollmentTrend'])->name('dashboard.enrollment-trend');
        Route::get('/api/dashboard/metrics', [DashboardController::class, 'getMetrics'])->name('dashboard.metrics');

        Route::get('/enrollment-stats', [DashboardController::class, 'getStats']);
    });

    // Student Routes - Consolidated
    // Student Side Enrollment Routes
    // Replace the existing Student Routes section in web.php with this:

    // Student Routes - Enhanced
    Route::middleware('role:Student')->prefix('student')->group(function () {
        // Dashboard
        Route::get('/dashboard', [StudentEnrollmentsController::class, 'dashboard'])->name('studentSide.dashboard');

        // Enrollment Management
        Route::get('/enrollments', [StudentEnrollmentsController::class, 'index'])->name('studentSide.enrollment.index');
        Route::get('/enrollments/create', [StudentEnrollmentsController::class, 'create'])->name('studentSide.enrollment.create');
        Route::post('/enrollments', [StudentEnrollmentsController::class, 'store'])->name('studentSide.enrollment.store');

        // Certificate of Registration (COR) Export
        Route::get('/enrollments/cor', [StudentEnrollmentsController::class, 'exportPdf'])->name('studentSide.enrollment.download.cor');

        // AJAX routes for dynamic data loading
        Route::get('/studentSide/enrollment/courses', [StudentEnrollmentsController::class, 'getCoursesByProgramAndYear'])->name('studentSide.enrollment.courses');
        Route::get('/studentSide/enrollment/sections', [StudentEnrollmentsController::class, 'getSectionsByProgram'])->name('studentSide.enrollment.sections');
        Route::get('/studentSide/enrollment/schedules', [StudentEnrollmentsController::class, 'getSchedulesByCourse'])->name('studentSide.enrollment.schedules');

        // Student Profile
        Route::get('/profile', [StudentProfileController::class, 'edit'])->name('studentSide.profile.edit');
        Route::get('/profile/edit', [StudentProfileController::class, 'show'])->name('studentSide.profile.show');
        Route::put('/profile', [StudentProfileController::class, 'update'])->name('studentSide.profile.update');
        Route::delete('/profile', [StudentProfileController::class, 'destroy'])->name('studentSide.profile.destroy');
    });

    // Add these routes inside the existing instructor middleware group in web.php

    Route::middleware('role:Instructor')->prefix('instructor')->group(function () {
        // Dashboard
        Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');

        // Students Management
        Route::get('/students', [InstructorDashboardController::class, 'allStudents'])->name('instructor.students.index');
        Route::get('/sections/{section}/students', [InstructorDashboardController::class, 'sectionStudents'])->name('instructor.section.students');

        // PDF Exports
        Route::get('/students/{student}/cor', [InstructorDashboardController::class, 'exportStudentCOR'])->name('instructor.student.cor');
        Route::get('/sections/{section}/students/pdf', [InstructorDashboardController::class, 'exportSectionStudentsPdf'])->name('instructor.section.students.pdf');
        Route::get('/students/pdf', [InstructorDashboardController::class, 'exportAllStudentsPdf'])->name('instructor.students.pdf');
        Route::get('/schedule/pdf', [InstructorDashboardController::class, 'exportSchedulePdf'])->name('instructor.schedule.pdf');

        // Stats API
        Route::get('/stats', [InstructorDashboardController::class, 'getStats'])->name('instructor.stat');
    });

    // Don't forget to add the import at the top of web.php:
    // use App\Http\Controllers\Instructor\InstructorDashboardController;

    // Profile routes (for all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

<?php

namespace App\Http\Controllers\StudentSide;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentEnrollmentsController extends Controller
{
    /**
     * Display enrollment history
     */
    public function index()
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['term', 'course', 'section'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('term_id');

        return view('studentSide.enrollment.index', [
            'title' => 'My Enrollments',
            'student' => $student,
            'enrollments' => $enrollments
        ]);
    }

    /**
     * Show enrollment form
     */
    public function create()
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $currentTerm = Term::where('status', 'active')->firstOrFail();

        // Check if already enrolled
        if (Enrollment::where('student_id', $student->id)
            ->where('term_id', $currentTerm->id)
            ->exists()
        ) {
            return redirect()->route('studentSide.enrollment.index')
                ->with('error', 'You are already enrolled for this term');
        }

        $program = Program::findOrFail($student->program_id);
        $courses = Course::where('program_id', $program->id)->get();
        $sections = Section::where('program_id', $program->id)->get();

        return view('studentSide.enrollment.create', [
            'title' => 'New Enrollment',
            'student' => $student,
            'currentTerm' => $currentTerm,
            'courses' => $courses,
            'sections' => $sections,
            'program' => $program
        ]);
    }

    /**
     * Store enrollment
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_ids' => 'required|array|min:1',
            'course_ids.*' => 'exists:courses,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $currentTerm = Term::where('status', 'active')->firstOrFail();

        try {
            foreach ($request->course_ids as $courseId) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'term_id' => $currentTerm->id,
                    'course_id' => $courseId,
                    'section_id' => $request->section_id,
                    'year_level' => $student->year_level,
                    'program_id' => $student->program_id
                ]);
            }

            return redirect()->route('studentSide.enrollment.index')
                ->with('success', 'Enrollment successful!');
        } catch (\Exception $e) {
            return back()->with('error', 'Enrollment failed: ' . $e->getMessage());
        }
    }

    public function exportPdf()
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        $currentTerm = Term::where('status', 'active')->firstOrFail();

        $enrollments = Enrollment::where('student_id', $student->id)
            ->where('term_id', $currentTerm->id)
            ->with(['course', 'section', 'term'])
            ->get();

        if ($enrollments->isEmpty()) {
            return redirect()->route('studentSide.enrollment.index')
                ->with('error', 'No enrollments found for the current term');
        }

        $pdf = PDF::loadView('studentSide.enrollment.cor-pdf', [
            'student' => $student,
            'term' => $currentTerm,
            'enrollments' => $enrollments,
            'date' => now()->format('F j, Y'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('COR_' . $student->last_name . '_' . $currentTerm->name . '.pdf');
    }

    public function dashboard()
    {
        $student = $this->getStudentRecord();

        if (!$student) {
            return redirect()->route('studentSide.profile.edit')
                ->with('error', 'Please complete your student profile first');
        }

        $currentTerm = Term::where('status', 'active')->first();
        $enrollments = collect();
        $todayClasses = collect();
        $enrolledCourses = 0;
        $totalCredits = 0;
        $isEnrolled = false;

        if ($currentTerm) {
            $enrollments = Enrollment::where('student_id', $student->id)
                ->where('term_id', $currentTerm->id)
                ->with(['course', 'section', 'schedule', 'schedule.room', 'schedule.instructor'])
                ->get();

            $todayClasses = $this->getTodaysClasses($enrollments);
            $enrolledCourses = $enrollments->count();
            $totalCredits = $enrollments->sum('course.credits');
            $isEnrolled = $enrolledCourses > 0;
        }

        return view('studentSide.dashboard', [
            'title' => 'Dashboard',
            'student' => $student,
            'currentTerm' => $currentTerm,
            'enrollments' => $enrollments,
            'todayClasses' => $todayClasses,
            'enrolledCourses' => $enrolledCourses,
            'totalCredits' => $totalCredits,
            'isEnrolled' => $isEnrolled
        ]);
    }

    private function getStudentRecord()
    {
        return Student::where('user_id', Auth::id())->first();
    }


    /**
     * Get today's classes for the student from their enrollments
     */
    private function getTodaysClasses($enrollments)
    {
        $todayClasses = collect();

        // Get today's day name (e.g., "Monday")
        $today = now()->format('l'); // Full day name

        foreach ($enrollments as $enrollment) {
            // Check if enrollment has a schedule and if it occurs today
            if ($enrollment->schedule && $enrollment->schedule->days) {
                // Convert schedule days to array and check if today is included
                $scheduleDays = array_map('trim', explode(',', $enrollment->schedule->days));

                if (in_array($today, $scheduleDays)) {
                    $todayClasses->push([
                        'course' => $enrollment->course,
                        'section' => $enrollment->section,
                        'schedule' => $enrollment->schedule,
                        'start_time' => $enrollment->schedule->start_time,
                        'end_time' => $enrollment->schedule->end_time
                    ]);
                }
            }
        }

        // Sort classes by start time
        return $todayClasses->sortBy('start_time')->values();
    }
}

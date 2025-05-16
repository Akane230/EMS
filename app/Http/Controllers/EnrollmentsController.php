<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Term;
use App\Models\Course;
use App\Models\Section;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EnrollmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Enrollment::query()
            ->with(['student', 'term', 'course', 'section', 'schedule']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->orWhereHas('course', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('course_code', 'like', "%{$search}%");
            });
        }

        // Filter by term
        if ($request->has('term_id') && $request->term_id) {
            $query->where('term_id', $request->term_id);
        }

        // Filter by year level
        if ($request->has('year_level') && $request->year_level) {
            $query->where('year_level', $request->year_level);
        }

        $enrollments = $query->latest()->paginate(10);
        $terms = Term::all();

        return view('enrollments.index', compact('enrollments', 'terms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $terms = Term::all();
        $courses = Course::all();
        $sections = Section::all();
        $schedules = Schedule::with(['course', 'section', 'room', 'instructor'])->get();
        
        return view('enrollments.create', compact('students', 'terms', 'courses', 'sections', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'term_id' => 'required|exists:terms,id',
            'course_code' => 'required|exists:courses,course_code',
            'section_id' => 'required|exists:sections,id',
            'schedule_id' => 'required|exists:schedules,id',
            'year_level' => 'required|integer|min:1|max:5',
        ]);

        Enrollment::create($request->all());

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'term', 'course', 'section', 'schedule']);
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        $students = Student::orderBy('last_name')->get();
        $terms = Term::all();
        $courses = Course::all();
        $sections = Section::all();
        $schedules = Schedule::with(['course', 'section', 'room', 'instructor'])->get();

        return view('enrollments.edit', compact('enrollment', 'students', 'terms', 'courses', 'sections', 'schedules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'term_id' => 'required|exists:terms,id',
            'course_code' => 'required|exists:courses,course_code',
            'section_id' => 'required|exists:sections,id',
            'schedule_id' => 'required|exists:schedules,id',
            'year_level' => 'required|integer|min:1|max:5',
        ]);

        $enrollment->update($request->all());

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment record deleted successfully.');
    }

    /**
     * Export enrollments to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Enrollment::with(['student', 'term', 'course', 'section', 'schedule']);

        // Apply filters if they exist
        if ($request->has('term_id') && $request->term_id) {
            $query->where('term_id', $request->term_id);
        }

        if ($request->has('year_level') && $request->year_level) {
            $query->where('year_level', $request->year_level);
        }

        $enrollments = $query->get();

        $pdf = PDF::loadView('enrollments.pdf', [
            'enrollments' => $enrollments,
            'title' => 'Enrollment Records'
        ]);

        return $pdf->download('enrollment_records_' . now()->format('Y-m-d') . '.pdf');
    }
}
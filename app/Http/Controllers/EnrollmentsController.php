<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Term;
use App\Models\Course;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\Program;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


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
                    $q->where('course_name', 'like', "%{$search}%")
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
        $programs = Program::all();
        $courses = Course::with('program')->get();
        $sections = Section::all();
        $schedules = Schedule::with(['course', 'section', 'room', 'instructor'])->get();

        return view('enrollments.create', compact(
            'students',
            'terms',
            'programs',
            'courses',
            'sections',
            'schedules'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'term_id' => 'required|exists:terms,id',
            'program_id' => 'required|exists:programs,id',
            'year_level' => 'required|integer|min:1|max:5',
            'section_id' => 'required|exists:sections,id',
            'course_codes' => 'required|array|min:1',
            'course_codes.*' => 'required|exists:courses,course_code',
            'schedule_ids' => 'required|array',
            'schedule_ids.*' => 'nullable|exists:schedules,id',
        ]);

        try {
            DB::beginTransaction();

            $enrollments = [];
            foreach ($request->course_codes as $courseCode) {
                $enrollment = Enrollment::create([
                    'student_id' => $request->student_id,
                    'term_id' => $request->term_id,
                    'course_code' => $courseCode,
                    'section_id' => $request->section_id,
                    'schedule_id' => $request->schedule_ids[$courseCode] ?? null,
                    'year_level' => $request->year_level,
                ]);
                $enrollments[] = $enrollment;
            }

            DB::commit();

            return redirect()->route('enrollments.index')
                ->with('success', count($enrollments) . ' courses enrolled successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating enrollments: ' . $e->getMessage());
        }
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
            'schedule_id' => 'nullable|exists:schedules,id',
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

    public function createBulk()
    {
        $students = Student::orderBy('last_name')->get();
        $terms = Term::all();
        $programs = Program::all();
        $courses = Course::all();
        $sections = Section::all();

        return view('enrollments.create-bulk', compact('students', 'terms', 'programs', 'courses', 'sections'));
    }

    /**
     * Get courses by program ID
     */
    /**
     * Get courses by program ID, including general education courses
     */
    public function getCoursesByProgram(Request $request)
    {
        $programId = $request->program_id;

        // Get the general education program ID
        $genEdProgramId = Program::where('program_name', 'General Education')->value('id');

        // If general education program exists, fetch both program-specific and gen-ed courses
        if ($genEdProgramId) {
            $courses = Course::where(function ($query) use ($programId, $genEdProgramId) {
                $query->where('program_id', $programId)
                    ->orWhere('program_id', $genEdProgramId);
            })
            ->orderBy('course_code')
            ->get();
        } else {
            // If no general education program exists, just get program-specific courses
            $courses = Course::where('program_id', $programId)
                ->orderBy('course_code')
                ->get();
        }

        return response()->json($courses);
    }

    /**
     * Get sections by program ID
     */
    public function getSectionsByProgram(Request $request)
    {
        $programId = $request->program_id;

        $sections = Section::where('program_id', $programId)
            ->orderBy('section_name')
            ->get();

        return response()->json($sections);
    }

    /**
     * Get schedules by course code and section ID
     */
    /**
     * Get schedules by course code and section ID for both program-specific and general education courses
     */
    /**
     * Debug and fixed version of getSchedulesByCourseAndSection method
     */
    /**
     * Debug and fixed version of getSchedulesByCourseAndSection method
     */
    /**
     * A more flexible approach to finding available schedules
     */
    public function getSchedulesByCourseAndSection(Request $request)
    {
        $courseCode = $request->course_code;
        $sectionId = $request->section_id;

        // Get schedules with eager loading for relationships
        $query = Schedule::with(['room', 'instructor'])
            ->where('course_code', $courseCode);

        // Try to find schedules for this specific section first
        $specificSchedules = clone $query;
        $specificSchedules->where('section_id', $sectionId);
        $schedules = $specificSchedules->get();

        // If no schedules found for this specific combination, find ANY schedules for this course
        if ($schedules->isEmpty()) {
            $schedules = $query->get();
        }

        return response()->json($schedules);
    }

    /**
     * Store multiple enrollments in a single transaction
     */
    public function storeBulk(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'term_id' => 'required|exists:terms,id',
            'program_id' => 'required|exists:programs,id',
            'year_level' => 'required|integer|min:1|max:5',
            'course_ids' => 'required|array|min:1',
            'course_ids.*' => 'required|exists:courses,course_code',
            'section_id' => 'required|exists:sections,id',
            'schedule_ids' => 'required|array|min:1',
            'schedule_ids.*' => 'nullable|exists:schedules,id',
        ]);

        try {
            DB::beginTransaction();

            $studentId = $request->student_id;
            $termId = $request->term_id;
            $yearLevel = $request->year_level;
            $sectionId = $request->section_id;
            $courseCodes = $request->course_ids;
            $scheduleIds = $request->schedule_ids;

            $created = [];

            foreach ($courseCodes as $index => $courseCode) {
                $scheduleId = $scheduleIds[$courseCode] ?? null;

                $enrollment = Enrollment::create([
                    'student_id' => $studentId,
                    'term_id' => $termId,
                    'course_code' => $courseCode,
                    'section_id' => $sectionId,
                    'schedule_id' => $scheduleId,
                    'year_level' => $yearLevel,
                ]);

                $created[] = $enrollment;
            }

            DB::commit();

            return redirect()->route('enrollments.index')
                ->with('success', count($created) . ' enrollment records created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])->withInput();
        }
    }
}

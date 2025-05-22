<?php

namespace App\Http\Controllers\StudentSide;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Term;
use App\Models\Course;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentEnrollmentsController extends Controller
{
    /**
     * Display the student dashboard with enrollment summary
     */
    public function dashboard()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }

        // Get current term
        $currentTerm = Term::where('status', 'active')->first();
        
        // Get student's current enrollments
        $currentEnrollments = collect();
        if ($currentTerm) {
            $currentEnrollments = Enrollment::with(['course', 'section', 'schedule.room', 'schedule.instructor'])
                ->where('student_id', $student->id)
                ->where('term_id', $currentTerm->id)
                ->get();
        }

        // Get enrollment statistics
        $totalEnrollments = Enrollment::where('student_id', $student->id)->count();
        $completedTerms = Enrollment::where('student_id', $student->id)
            ->distinct('term_id')
            ->count();

        // Get latest enrollment to determine current year level and program
        $latestEnrollment = Enrollment::with(['term', 'course.program'])
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $currentYearLevel = $latestEnrollment ? $latestEnrollment->year_level : 1;
        $currentProgram = $latestEnrollment ? $latestEnrollment->course->program : null;

        return view('studentSide.dashboard', compact(
            'student',
            'currentTerm',
            'currentEnrollments',
            'totalEnrollments',
            'completedTerms',
            'currentYearLevel',
            'currentProgram'
        ));
    }

    /**
     * Display all enrollments for the student
     */
    public function index()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }

        // Get all enrollments grouped by term
        $enrollmentsByTerm = Enrollment::with(['term', 'course', 'section', 'schedule.room', 'schedule.instructor'])
            ->where('student_id', $student->id)
            ->get()
            ->groupBy('term_id')
            ->map(function ($enrollments) {
                return [
                    'term' => $enrollments->first()->term,
                    'enrollments' => $enrollments,
                    'total_units' => $enrollments->sum('course.credits')
                ];
            })
            ->sortByDesc(function ($item) {
                return $item['term']->created_at;
            });

        return view('studentSide.enrollments.index', compact('enrollmentsByTerm', 'student'));
    }

    /**
     * Show the enrollment form
     */
    public function create()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please complete your student profile first.');
        }

        // Get current active term
        $currentTerm = Term::where('status', 'active')->first();
        if (!$currentTerm) {
            return back()->with('error', 'No active enrollment term available.');
        }

        // Check if student is already enrolled for current term
        $existingEnrollment = Enrollment::where('student_id', $student->id)
            ->where('term_id', $currentTerm->id)
            ->exists();

        if ($existingEnrollment) {
            return redirect()->route('studentSide.enrollment.index')
                ->with('info', 'You are already enrolled for the current term.');
        }

        // Determine if student is freshman (no previous enrollments)
        $previousEnrollments = Enrollment::where('student_id', $student->id)->count();
        $isFreshman = $previousEnrollments === 0;

        $program = null;
        $yearLevel = 1;
        $programs = collect();
        $sections = collect();

        if ($isFreshman) {
            // Freshman can select any program
            $programs = Program::orderBy('program_name')->get();
        } else {
            // Get student's program and calculate year level based on latest enrollment
            $latestEnrollment = Enrollment::with(['term', 'course.program'])
                ->where('student_id', $student->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latestEnrollment) {
                $program = $latestEnrollment->course->program;
                $yearLevel = $this->calculateYearLevel($latestEnrollment, $currentTerm);
                
                // Get sections for the student's program
                $sections = Section::where('program_id', $program->id)
                    ->orderBy('section_name')
                    ->get();
            }
        }

        return view('studentSide.enrollments.create', compact(
            'student',
            'currentTerm',
            'isFreshman',
            'program',
            'programs',
            'yearLevel',
            'sections'
        ));
    }

    /**
     * Store the enrollment
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return back()->with('error', 'Student profile not found.');
        }

        // Validation rules
        $rules = [
            'term_id' => 'required|exists:terms,id',
            'year_level' => 'required|integer|min:1|max:5',
            'section_id' => 'required|exists:sections,id',
            'course_codes' => 'required|array|min:1',
            'course_codes.*' => 'required|exists:courses,course_code',
            'schedule_ids' => 'required|array',
            'schedule_ids.*' => 'nullable|exists:schedules,id',
        ];

        // Add program_id validation for freshmen
        $isFreshman = Enrollment::where('student_id', $student->id)->count() === 0;
        if ($isFreshman) {
            $rules['program_id'] = 'required|exists:programs,id';
        }

        $request->validate($rules);

        // Additional validations
        $term = Term::findOrFail($request->term_id);
        
        // Check if term is active
        if ($term->status !== 'active') {
            return back()->with('error', 'Selected term is not available for enrollment.');
        }

        // Check if student is already enrolled for this term
        $existingEnrollment = Enrollment::where('student_id', $student->id)
            ->where('term_id', $request->term_id)
            ->exists();

        if ($existingEnrollment) {
            return back()->with('error', 'You are already enrolled for this term.');
        }

        // Validate courses belong to the correct program and year level
        $programId = $isFreshman ? $request->program_id : null;
        if (!$isFreshman) {
            $latestEnrollment = Enrollment::with('course.program')
                ->where('student_id', $student->id)
                ->orderBy('created_at', 'desc')
                ->first();
            $programId = $latestEnrollment->course->program->id;
        }

        // Get valid courses for the program and year level
        $genEdProgramId = Program::where('program_name', 'General Education')->value('id');
        $validCourses = Course::where(function ($query) use ($programId, $genEdProgramId) {
            $query->where('program_id', $programId);
            if ($genEdProgramId) {
                $query->orWhere('program_id', $genEdProgramId);
            }
        })
        ->where('year_level', $request->year_level)
        ->pluck('course_code')
        ->toArray();

        $invalidCourses = array_diff($request->course_codes, $validCourses);
        if (!empty($invalidCourses)) {
            return back()->with('error', 'Some selected courses are not valid for your program and year level.');
        }

        // Check for schedule conflicts
        $scheduleConflicts = $this->checkScheduleConflicts($request->schedule_ids, $request->course_codes);
        if ($scheduleConflicts) {
            return back()->with('error', 'Schedule conflicts detected: ' . $scheduleConflicts);
        }

        try {
            DB::beginTransaction();

            $enrollments = [];
            foreach ($request->course_codes as $courseCode) {
                $enrollment = Enrollment::create([
                    'student_id' => $student->id,
                    'term_id' => $request->term_id,
                    'course_code' => $courseCode,
                    'section_id' => $request->section_id,
                    'schedule_id' => $request->schedule_ids[$courseCode] ?? null,
                    'year_level' => $request->year_level,
                ]);
                $enrollments[] = $enrollment;
            }

            DB::commit();

            return redirect()->route('studentSide.enrollment.index')
                ->with('success', 'Successfully enrolled in ' . count($enrollments) . ' courses!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student enrollment error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during enrollment. Please try again.');
        }
    }

    /**
     * Export Certificate of Registration (COR) to PDF
     */
    public function exportPdf()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return back()->with('error', 'Student profile not found.');
        }

        // Get current term enrollments
        $currentTerm = Term::where('status', 'active')->first();
        if (!$currentTerm) {
            return back()->with('error', 'No active term found.');
        }

        $enrollments = Enrollment::with(['course', 'section', 'schedule.room', 'schedule.instructor', 'term'])
            ->where('student_id', $student->id)
            ->where('term_id', $currentTerm->id)
            ->get();

        if ($enrollments->isEmpty()) {
            return back()->with('error', 'No enrollment records found for current term.');
        }

        $totalUnits = $enrollments->sum('course.credits');
        $program = $enrollments->first()->course->program;

        $pdf = PDF::loadView('studentSide.enrollments.cor-pdf', [
            'student' => $student,
            'enrollments' => $enrollments,
            'term' => $currentTerm,
            'totalUnits' => $totalUnits,
            'program' => $program
        ]);

        return $pdf->download('COR_' . $student->last_name . '_' . $currentTerm->schoolyear_semester . '.pdf');
    }

    /**
     * Get courses by program and year level for AJAX
     */
    public function getCoursesByProgramAndYear(Request $request)
    {
        $programId = $request->program_id;
        $yearLevel = $request->year_level;

        // Get general education program ID
        $genEdProgramId = Program::where('program_name', 'General Education')->value('id');

        // Build query for courses
        $query = Course::where('year_level', $yearLevel);
        
        if ($genEdProgramId) {
            $query->where(function ($q) use ($programId, $genEdProgramId) {
                $q->where('program_id', $programId)
                  ->orWhere('program_id', $genEdProgramId);
            });
        } else {
            $query->where('program_id', $programId);
        }

        $courses = $query->orderBy('course_code')->get();

        return response()->json($courses);
    }

    /**
     * Get sections by program for AJAX
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
     * Get schedules by course code for AJAX
     */
    public function getSchedulesByCourse(Request $request)
    {
        $courseCode = $request->course_code;
        $sectionId = $request->section_id;

        $query = Schedule::with(['room', 'instructor'])
            ->where('course_code', $courseCode);

        if ($sectionId) {
            // Try to find schedules for specific section first
            $specificSchedules = clone $query;
            $specificSchedules->where('section_id', $sectionId);
            $schedules = $specificSchedules->get();

            // If no schedules found for specific section, get all schedules for the course
            if ($schedules->isEmpty()) {
                $schedules = $query->get();
            }
        } else {
            $schedules = $query->get();
        }

        return response()->json($schedules);
    }

    /**
     * Calculate year level based on previous enrollment and current term
     */
    private function calculateYearLevel($latestEnrollment, $currentTerm)
    {
        $previousTerm = $latestEnrollment->term;
        $previousYearLevel = $latestEnrollment->year_level;

        // Extract school year and semester from term names
        // Assuming format: "2025-2026 1st Semester" or "2025-2026 2nd Semester"
        preg_match('/(\d{4}-\d{4})\s+(\d+)(st|nd|rd|th)\s+Semester/', $previousTerm->schoolyear_semester, $prevMatches);
        preg_match('/(\d{4}-\d{4})\s+(\d+)(st|nd|rd|th)\s+Semester/', $currentTerm->schoolyear_semester, $currMatches);

        if (empty($prevMatches) || empty($currMatches)) {
            // If we can't parse the format, default to same year level
            return $previousYearLevel;
        }

        $prevSchoolYear = $prevMatches[1];
        $prevSemester = (int)$prevMatches[2];
        $currSchoolYear = $currMatches[1];
        $currSemester = (int)$currMatches[2];

        // If it's a new school year, increment year level
        if ($currSchoolYear > $prevSchoolYear) {
            return min($previousYearLevel + 1, 5); // Cap at 5th year
        }

        // If same school year but moved from 2nd semester to 1st semester (new academic year)
        if ($currSchoolYear === $prevSchoolYear && $prevSemester === 2 && $currSemester === 1) {
            return min($previousYearLevel + 1, 5);
        }

        // Otherwise, stay at same year level
        return $previousYearLevel;
    }

    /**
     * Check for schedule conflicts
     */
    private function checkScheduleConflicts($scheduleIds, $courseCodes)
    {
        $conflicts = [];
        $schedules = Schedule::whereIn('id', array_filter($scheduleIds))->get();

        for ($i = 0; $i < count($schedules); $i++) {
            for ($j = $i + 1; $j < count($schedules); $j++) {
                $schedule1 = $schedules[$i];
                $schedule2 = $schedules[$j];

                // Check if schedules overlap
                if ($this->schedulesOverlap($schedule1, $schedule2)) {
                    $conflicts[] = "Conflict between {$schedule1->course_code} and {$schedule2->course_code}";
                }
            }
        }

        return empty($conflicts) ? false : implode(', ', $conflicts);
    }

    /**
     * Check if two schedules overlap
     */
    private function schedulesOverlap($schedule1, $schedule2)
    {
        // Check if same day
        if ($schedule1->day !== $schedule2->day) {
            return false;
        }

        $start1 = strtotime($schedule1->starting_time);
        $end1 = strtotime($schedule1->ending_time);
        $start2 = strtotime($schedule2->starting_time);
        $end2 = strtotime($schedule2->ending_time);

        // Check if time ranges overlap
        return ($start1 < $end2) && ($start2 < $end1);
    }
}
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

        $currentYearLevel = $latestEnrollment ? $this->calculateCurrentYearLevel($student->id) : 1;
        $currentProgram = $latestEnrollment ? $this->getStudentProgram($student->id) : null;

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
            $programs = Program::where('program_name', '!=', 'General Education')
                ->orderBy('program_name')->get();
        } else {
            // Get student's program and calculate current year level
            $program = $this->getStudentProgram($student->id);
            $yearLevel = $this->calculateCurrentYearLevel($student->id);
            
            // Get sections for the student's program
            if ($program) {
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
            $program = $this->getStudentProgram($student->id);
            $programId = $program ? $program->id : null;
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
        $program = $this->getStudentProgram($student->id);

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
        $query = Course::with('program')->where('year_level', $yearLevel);
        
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
     * Get schedules by course code for AJAX - Updated to filter by program and section
     */
    public function getSchedulesByCourse(Request $request)
    {
        $courseCode = $request->course_code;
        $sectionId = $request->section_id;
        $programId = $request->program_id;

        // Start with base query
        $query = Schedule::with(['room', 'instructor', 'course', 'section'])
            ->where('course_code', $courseCode);

        // If section is provided, filter by section
        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        // If program is provided, ensure the schedule's section belongs to the program
        if ($programId) {
            $query->whereHas('section', function ($q) use ($programId) {
                $q->where('program_id', $programId);
            });
        }

        $schedules = $query->orderBy('day')
            ->orderBy('starting_time')
            ->get();

        // If no schedules found with specific section, try to find schedules 
        // for the same course but different sections within the same program
        if ($schedules->isEmpty() && $sectionId && $programId) {
            $fallbackQuery = Schedule::with(['room', 'instructor', 'course', 'section'])
                ->where('course_code', $courseCode)
                ->whereHas('section', function ($q) use ($programId) {
                    $q->where('program_id', $programId);
                });

            $schedules = $fallbackQuery->orderBy('day')
                ->orderBy('starting_time')
                ->get();
        }

        return response()->json($schedules);
    }

    /**
     * Get student's primary program (excluding General Education)
     */
    private function getStudentProgram($studentId)
    {
        // Get the most recent enrollment that's NOT General Education
        $enrollment = Enrollment::with('course.program')
            ->where('student_id', $studentId)
            ->whereHas('course.program', function ($query) {
                $query->where('program_name', '!=', 'General Education');
            })
            ->orderBy('created_at', 'desc')
            ->first();

        return $enrollment ? $enrollment->course->program : null;
    }

    /**
     * Calculate current year level for a student based on all their completed terms
     */
    private function calculateCurrentYearLevel($studentId)
    {
        // Get the student's first enrollment (their starting point)
        $firstEnrollment = Enrollment::with('term')
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$firstEnrollment) {
            return 1; // Default to 1st year if no enrollments
        }

        // Get all unique terms the student has been enrolled in, ordered chronologically
        $enrolledTerms = Enrollment::with('term')
            ->where('student_id', $studentId)
            ->select('term_id')
            ->distinct()
            ->get()
            ->pluck('term')
            ->sortBy(function ($term) {
                // Sort by school year first, then by semester
                preg_match('/(\d{4}-\d{4})\s+(\d+)(st|nd|rd|th)\s+Semester/', $term->schoolyear_semester, $matches);
                if (!empty($matches)) {
                    $schoolYear = $matches[1];
                    $semester = (int)$matches[2];
                    return $schoolYear . '_' . str_pad($semester, 2, '0', STR_PAD_LEFT);
                }
                return $term->schoolyear_semester;
            });

        // Get the first term info
        $firstTerm = $enrolledTerms->first();
        $firstYearLevel = $firstEnrollment->year_level;

        // Get current active term
        $currentTerm = Term::where('status', 'active')->first();
        if (!$currentTerm) {
            // If no active term, return the year level from the latest enrollment
            $latestEnrollment = Enrollment::where('student_id', $studentId)
                ->orderBy('created_at', 'desc')
                ->first();
            return $latestEnrollment ? $latestEnrollment->year_level : $firstYearLevel;
        }

        // Calculate year level progression based on unique school years completed
        $completedSchoolYears = $this->getCompletedSchoolYears($enrolledTerms);
        $currentSchoolYear = $this->parseSchoolYear($currentTerm->schoolyear_semester);
        $firstSchoolYear = $this->parseSchoolYear($firstTerm->schoolyear_semester);

        // Count how many full school years have passed since the first enrollment
        $yearsPassed = 0;
        if ($currentSchoolYear && $firstSchoolYear) {
            $firstYear = (int)substr($firstSchoolYear, 0, 4);
            $currentYear = (int)substr($currentSchoolYear, 0, 4);
            $yearsPassed = $currentYear - $firstYear;
        }

        // Calculate the new year level
        $newYearLevel = $firstYearLevel + $yearsPassed;
        
        // Cap at 5th year
        return min($newYearLevel, 5);
    }

    /**
     * Get completed school years from enrolled terms
     */
    private function getCompletedSchoolYears($enrolledTerms)
    {
        $schoolYears = [];
        
        foreach ($enrolledTerms as $term) {
            $schoolYear = $this->parseSchoolYear($term->schoolyear_semester);
            if ($schoolYear && !in_array($schoolYear, $schoolYears)) {
                $schoolYears[] = $schoolYear;
            }
        }
        
        return $schoolYears;
    }

    /**
     * Parse school year from term string
     */
    private function parseSchoolYear($termString)
    {
        preg_match('/(\d{4}-\d{4})/', $termString, $matches);
        return !empty($matches) ? $matches[1] : null;
    }

    /**
     * Calculate year level based on previous enrollment and current term (legacy method - kept for compatibility)
     */
    private function calculateYearLevel($latestEnrollment, $currentTerm)
    {
        // Use the new calculation method instead
        return $this->calculateCurrentYearLevel($latestEnrollment->student_id);
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
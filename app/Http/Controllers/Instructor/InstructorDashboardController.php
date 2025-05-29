<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Section;
use App\Models\Term;
use App\Models\Program;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class InstructorDashboardController extends Controller
{
    /**
     * Display the instructor dashboard
     */
    public function index()
    {
        $user = Auth::user();

        $instructor = Instructor::where('user_id', $user->id)->first();

        // Get current active term
        $currentTerm = Term::where('status', 'active')
            ->orWhere('end_date', '>=', now())
            ->orderBy('start_date', 'desc')
            ->first();

        // Get instructor's assigned schedules with related data
        $schedules = Schedule::with([
            'course:course_code,course_name,credits',
            'section:id,section_name,program_id',
            'section.program:id,program_name,department_id',
            'section.program.department:id,department_name',
            'room:id,roomname'
        ])
            ->where('instructor_id', $instructor->id)
            ->orderBy('day')
            ->orderBy('starting_time')
            ->get();

        // Get total students count for this instructor's sections in current term
        $totalStudents = Enrollment::whereHas('schedule', function ($query) use ($instructor) {
            $query->where('instructor_id', $instructor->id);
        })
            ->when($currentTerm, function ($query) use ($currentTerm) {
                return $query->where('term_id', $currentTerm->id);
            })
            ->distinct('student_id')
            ->count('student_id');

        // Get sections the instructor is handling
        $sections = Section::whereHas('schedules', function ($query) use ($instructor) {
            $query->where('instructor_id', $instructor->id);
        })
            ->with([
                'program:id,program_name',
                'schedules' => function ($query) use ($instructor) {
                    $query->where('instructor_id', $instructor->id);
                }
            ])
            ->withCount([
                'enrollments as students_count' => function ($query) use ($instructor) {
                    $query->whereHas('schedule', function ($scheduleQuery) use ($instructor) {
                        $scheduleQuery->where('instructor_id', $instructor->id);
                    });
                }
            ])
            ->distinct()
            ->get();

        return view('instructor.dashboard', compact('schedules', 'totalStudents', 'sections', 'currentTerm', 'instructor'));
    }

    /**
     * Show students for a specific section
     */
    public function sectionStudents($sectionId)
    {
        $instructor = Auth::user();

        // Verify the instructor teaches this section
        $section = Section::with([
            'program:id,program_name,department_id',
            'program.department:id,department_name'
        ])
            ->whereHas('schedules', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->findOrFail($sectionId);

        // Get enrolled students in this section with their enrollment details
        $students = Student::with([
            'user:id,name,avatar',
            'enrollments' => function ($query) use ($sectionId, $instructor) {
                $query->whereHas('schedule', function ($scheduleQuery) use ($sectionId, $instructor) {
                    $scheduleQuery->where('section_id', $sectionId)
                        ->where('instructor_id', $instructor->id);
                })
                    ->with([
                        'schedule:id,course_code,section_id,instructor_id,starting_time,ending_time,day',
                        'schedule.course:course_code,course_name,credits',
                        'term:id,schoolyear_semester,status'
                    ]);
            }
        ])
            ->whereHas('enrollments.schedule', function ($query) use ($sectionId, $instructor) {
                $query->where('section_id', $sectionId)
                    ->where('instructor_id', $instructor->id);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('instructor.section-students', compact('students', 'section'));
    }

    /**
     * Show all students the instructor is handling
     */
    public function allStudents()
    {
        $user = Auth::user();

        $instructor = Instructor::where('user_id', $user->id)->first();

        // Get all students enrolled in courses taught by this instructor
        $students = Student::with([
            'user:id,name,avatar',
            'enrollments' => function ($query) use ($instructor) {
                $query->whereHas('schedule', function ($scheduleQuery) use ($instructor) {
                    $scheduleQuery->where('instructor_id', $instructor->id);
                })
                    ->with([
                        'schedule:id,course_code,section_id,instructor_id,starting_time,ending_time,day',
                        'schedule.course:course_code,course_name,credits',
                        'schedule.section:id,section_name',
                        'term:id,schoolyear_semester,status'
                    ]);
            }
        ])
            ->whereHas('enrollments.schedule', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('instructor.all-students', compact('students'));
    }

    /**
     * Export student COR (Certificate of Registration)
     */
    public function exportStudentCOR($studentId)
    {
        $instructor = Auth::user();

        // Get student with enrollments only for courses taught by this instructor
        $student = Student::with([
            'user:id,name',
            'enrollments' => function ($query) use ($instructor) {
                $query->whereHas('schedule', function ($scheduleQuery) use ($instructor) {
                    $scheduleQuery->where('instructor_id', $instructor->id);
                })
                    ->with([
                        'schedule:id,course_code,section_id,instructor_id,starting_time,ending_time,day',
                        'schedule.course:course_code,course_name,credits',
                        'schedule.section:id,section_name',
                        'term:id,schoolyear_semester,status'
                    ]);
            }
        ])
            ->whereHas('enrollments.schedule', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->findOrFail($studentId);

        // Group enrollments by term
        $enrollmentsByTerm = $student->enrollments->groupBy('term.schoolyear_semester');

        $pdf = Pdf::loadView('instructor.pdf.student-cor', compact('student', 'enrollmentsByTerm'));

        return $pdf->download($student->first_name . '_' . $student->last_name . '_COR.pdf');
    }

    /**
     * Export section students list as PDF
     */
    public function exportSectionStudentsPdf($sectionId)
    {
        $instructor = Auth::user();

        // Verify the instructor teaches this section
        $section = Section::with([
            'program:id,program_name,department_id',
            'program.department:id,department_name'
        ])
            ->whereHas('schedules', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->findOrFail($sectionId);

        // Get enrolled students in this section
        $students = Student::with([
            'user:id,name',
            'enrollments' => function ($query) use ($sectionId, $instructor) {
                $query->whereHas('schedule', function ($scheduleQuery) use ($sectionId, $instructor) {
                    $scheduleQuery->where('section_id', $sectionId)
                        ->where('instructor_id', $instructor->id);
                })
                    ->with([
                        'schedule:id,course_code,section_id,instructor_id',
                        'schedule.course:course_code,course_name,credits',
                        'term:id,schoolyear_semester'
                    ]);
            }
        ])
            ->whereHas('enrollments.schedule', function ($query) use ($sectionId, $instructor) {
                $query->where('section_id', $sectionId)
                    ->where('instructor_id', $instructor->id);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $pdf = Pdf::loadView('instructor.pdf.section-students', compact('students', 'section', 'instructor'));

        return $pdf->download('Section_' . $section->section_name . '_Students.pdf');
    }

    /**
     * Export all students handled by instructor as PDF
     */
    public function exportAllStudentsPdf()
    {
        $user = Auth::user();

        $instructor = Instructor::where('user_id', $user->id)->first();

        // Get all students enrolled in courses taught by this instructor
        $students = Student::with([
            'user:id,name',
            'enrollments' => function ($query) use ($instructor) {
                $query->whereHas('schedule', function ($scheduleQuery) use ($instructor) {
                    $scheduleQuery->where('instructor_id', $instructor->id);
                })
                    ->with([
                        'schedule:id,course_code,section_id,instructor_id',
                        'schedule.course:course_code,course_name,credits',
                        'schedule.section:id,section_name',
                        'term:id,schoolyear_semester'
                    ]);
            }
        ])
            ->whereHas('enrollments.schedule', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        // Group students by section
        $studentsBySection = [];
        foreach ($students as $student) {
            foreach ($student->enrollments as $enrollment) {
                $sectionName = $enrollment->schedule->section->section_name;
                if (!isset($studentsBySection[$sectionName])) {
                    $studentsBySection[$sectionName] = [];
                }
                if (!in_array($student->id, array_column($studentsBySection[$sectionName], 'id'))) {
                    $studentsBySection[$sectionName][] = $student;
                }
            }
        }

        $pdf = Pdf::loadView('instructor.pdf.all-students', compact('studentsBySection', 'instructor'));

        return $pdf->download('All_Students_' . $instructor->first_name . '_' . $instructor->last_name . '.pdf');
    }

    /**
     * Export instructor's schedule as PDF
     */
    public function exportSchedulePdf()
    {
        $user = Auth::user();

        $instructor = Instructor::where('user_id', $user->id)->first();

        // Get current active term (same logic as index method)
        $currentTerm = Term::where('status', 'active')
            ->orWhere('end_date', '>=', now())
            ->orderBy('start_date', 'desc')
            ->first();

        // Get instructor's assigned schedules
        $schedules = Schedule::with([
            'course:course_code,course_name,credits',
            'section:id,section_name,program_id',
            'section.program:id,program_name',
            'room:id,roomname'
        ])
            ->where('instructor_id', $instructor->id)
            ->orderBy('day')
            ->orderBy('starting_time')
            ->get();

        // Group schedules by day for better presentation
        $schedulesByDay = $schedules->groupBy('day');

        $pdf = Pdf::loadView('instructor.pdf.schedule', compact('schedulesByDay', 'instructor', 'currentTerm'));

        return $pdf->download('Schedule_' . $instructor->first_name . '_' . $instructor->last_name . '.pdf');
    }

    /**
     * Get instructor's teaching statistics
     */
    public function getStats()
    {
        $instructor = Auth::user();

        $stats = [
            'total_courses' => Schedule::where('instructor_id', $instructor->id)
                ->distinct('course_code')
                ->count(),
            'total_sections' => Schedule::where('instructor_id', $instructor->id)
                ->distinct('section_id')
                ->count(),
            'total_students' => Enrollment::whereHas('schedule', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })->distinct('student_id')->count(),
            'total_schedules' => Schedule::where('instructor_id', $instructor->id)->count()
        ];

        return response()->json($stats);
    }

    /**
     * Get students by term for a specific instructor
     */
    public function getStudentsByTerm($termId = null)
    {
        $instructor = Auth::user();

        // If no term specified, get current active term
        if (!$termId) {
            $currentTerm = Term::where('status', 'active')
                ->orWhere('end_date', '>=', now())
                ->orderBy('start_date', 'desc')
                ->first();
            $termId = $currentTerm ? $currentTerm->id : null;
        }

        if (!$termId) {
            return response()->json(['error' => 'No active term found'], 404);
        }

        // Get students enrolled in courses taught by this instructor for specific term
        $students = Student::with([
            'user:id,name',
            'enrollments' => function ($query) use ($instructor, $termId) {
                $query->whereHas('schedule', function ($scheduleQuery) use ($instructor) {
                    $scheduleQuery->where('instructor_id', $instructor->id);
                })
                    ->where('term_id', $termId)
                    ->with([
                        'schedule:id,course_code,section_id,instructor_id',
                        'schedule.course:course_code,course_name,credits',
                        'schedule.section:id,section_name',
                        'term:id,schoolyear_semester'
                    ]);
            }
        ])
            ->whereHas('enrollments', function ($query) use ($instructor, $termId) {
                $query->whereHas('schedule', function ($scheduleQuery) use ($instructor) {
                    $scheduleQuery->where('instructor_id', $instructor->id);
                })
                    ->where('term_id', $termId);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return response()->json($students);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Program;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $courses = Course::when($search, function ($query, $search) {
            return $query->where('course_code', 'like', "%{$search}%")
                ->orWhere('course_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('courses.index', compact('courses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = Program::all(); // Retrieve all programs from the database
        return view('courses.create', compact('programs')); // Pass programs to the view
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required',
            'course_name' => 'required',
            'year_level' => 'required',
            'description',
            'program_id' => 'required',
            'credits' => 'required',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $programs = Program::all(); // Retrieve all programs
        return view('courses.edit', compact('course', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    // In CourseController.php, update the update method:
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_code,' . $course->course_code . ',course_code',
            'course_name' => 'required',
            'year_level' => 'required',
            'description',
            'program_id' => 'required',
            'credits' => 'required',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }

    public function exportPdf()
    {
        $course = Course::all();

        $pdf = PDF::loadView('courses.pdf', [
            'courses' => $course,
            'title' => 'Course Records'
        ]);

        return $pdf->download('course_records_' . now()->format('Y-m-d') . '.pdf');
    }
}

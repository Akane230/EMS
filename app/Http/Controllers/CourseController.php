<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

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
            ->orWhere('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    })->paginate(10);

    return view('courses.index', compact('courses'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required',
            'course_name' => 'required',
            'description' => 'required',
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
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_id',
            'course_name' => 'required',
            'description' => 'required',
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
}
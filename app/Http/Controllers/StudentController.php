<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = Student::when($search, function ($query, $search) {
            return $query->where('id', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'country' => 'nullable',
            'province' => 'nullable',
            'city' => 'nullable',
            'street' => 'nullable',
            'zipcode' => 'nullable',
            'contact_number' => 'nullable',
            'status' => 'required|string|max:50',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'country' => 'nullable',
            'province' => 'nullable',
            'city' => 'nullable',
            'street' => 'nullable',
            'zipcode' => 'nullable',
            'contact_number' => 'nullable',
            'status' => 'required|string|max:50',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully');
    }

    public function exportPdf()
    {
        $students = Student::all();

        $pdf = PDF::loadView('students.pdf', [
            'students' => $students,
            'title' => 'Student Records'
        ]);

        return $pdf->download('student_records_' . now()->format('Y-m-d') . '.pdf');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $instructors = Instructor::when($search, function ($query, $search) {
            return $query->where('id', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instructors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:instructors|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'contact_number' => 'nullable|string',
            'country' => 'nullable|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id'
        ]);

        Instructor::create($request->all());

        return redirect()->route('instructors.index')
            ->with('success', 'Instructor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        return view('instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instructor)
    {
        return view('instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instructor $instructor)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:instructors,email,' . $instructor->id,
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'contact_number' => 'nullable|string',
            'country' => 'nullable|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id'
        ]);

        $instructor->update($request->all());

        return redirect()->route('instructors.index')
            ->with('success', 'Instructor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        $instructor->delete();

        return redirect()->route('instructors.index')
            ->with('success', 'Instructor deleted successfully');
    }

    /**
     * Export instructors to PDF
     */
    public function exportPdf()
    {
        $instructors = Instructor::all();

        $pdf = PDF::loadView('instructors.pdf', [
            'instructors' => $instructors,
            'title' => 'Instructor Records'
        ]);

        return $pdf->download('instructor_records_' . now()->format('Y-m-d') . '.pdf');
    }
}
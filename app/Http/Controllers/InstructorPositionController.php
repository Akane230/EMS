<?php

namespace App\Http\Controllers;

use App\Models\InstructorPosition;
use App\Models\Instructor;
use App\Models\Position;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InstructorPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = InstructorPosition::with(['instructor', 'position']);
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('instructor', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%");
            })->orWhereHas('position', function($q) use ($search) {
                $q->where('position_name', 'like', "%{$search}%");
            });
        }
        
        $instructorPositions = $query->latest()->paginate(10);
        
        return view('instructor-positions.index', compact('instructorPositions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructors = Instructor::all();
        $positions = Position::all();
        
        return view('instructor-positions.create', compact('instructors', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'position_id' => 'required|exists:positions,id',
        ]);
        
        InstructorPosition::create($request->all());
        
        return redirect()->route('instructor-positions.index')
            ->with('success', 'Instructor position assigned successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(InstructorPosition $instructorPosition)
    {
        $instructorPosition->load(['instructor', 'position']);
        
        return view('instructor-positions.show', compact('instructorPosition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstructorPosition $instructorPosition)
    {
        $instructors = Instructor::all();
        $positions = Position::all();
        
        return view('instructor-positions.edit', compact('instructorPosition', 'instructors', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InstructorPosition $instructorPosition)
    {
        $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'position_id' => 'required|exists:positions,id',
        ]);
        
        $instructorPosition->update($request->all());
        
        return redirect()->route('instructor-positions.index')
            ->with('success', 'Instructor position updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstructorPosition $instructorPosition)
    {
        $instructorPosition->delete();
        
        return redirect()->route('instructor-positions.index')
            ->with('success', 'Instructor position removed successfully');
    }

    /**
     * Export records to PDF
     */
    public function exportPdf()
    {
        $instructorPositions = InstructorPosition::with(['instructor', 'position'])->get();

        $pdf = PDF::loadView('instructor-positions.pdf', [
            'instructorPositions' => $instructorPositions,
            'title' => 'Instructor Position Records'
        ]);

        return $pdf->download('instructor_positions_' . now()->format('Y-m-d') . '.pdf');
    }
}
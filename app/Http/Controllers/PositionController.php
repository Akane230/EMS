<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department; // Add this import
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $positions = Position::with('department') // Eager load department
            ->when($search, function($query, $search) {
                return $query->where('position_name', 'like', "%{$search}%")
                    ->orWhereHas('department', function($q) use ($search) {
                        $q->where('department_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->orderBy('position_name')
            ->paginate(10);
        
        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all(); // Get all departments
        return view('positions.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string|max:100|unique:positions',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        Position::create([
            'position_name' => $request->position_name,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('positions.index')
            ->with('success', 'Position created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        $position->load('department'); // Eager load department
        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        $departments = Department::all(); // Get all departments
        return view('positions.edit', compact('position', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        $request->validate([
            'position_name' => 'required|string|max:100|unique:positions,position_name,' . $position->id,
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $position->update([
            'position_name' => $request->position_name,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('positions.index')
            ->with('success', 'Position updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Position deleted successfully.');
    }
    
    /**
     * Export positions as PDF.
     */
    public function exportPdf()
    {
        $positions = Position::with('department') // Include department in PDF
            ->orderBy('position_name')
            ->get();

        $pdf = PDF::loadView('positions.pdf', [
            'positions' => $positions,
            'title' => 'Position Records'
        ]);

        return $pdf->download('position_records_' . now()->format('Y-m-d') . '.pdf');
    }
}
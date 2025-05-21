<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Department;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $programs = Program::with('department') // Eager load the department
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%")
                    ->orWhere('program_name', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('department_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('programs.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program_name' => 'required|string|max:100',
            'program_description' => 'required|string',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('programs.create')
                ->withErrors($validator)
                ->withInput();
        }

        Program::create($request->all());

        return redirect()->route('programs.index')
            ->with('success', 'Program created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        $program->load('department'); // Changed from 'departments' to 'department'
        return view('programs.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        $departments = Department::all();
        return view('programs.edit', compact('program', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        $validator = Validator::make($request->all(), [
            'program_name' => 'required|string|max:100',
            'program_description' => 'required|string',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('programs.edit', $program->id)
                ->withErrors($validator)
                ->withInput();
        }

        $program->update($request->all());

        return redirect()->route('programs.index')
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    public function exportPdf()
    {
        $program = Program::all();

        $pdf = PDF::loadView('programs.pdf', [
            'programs' => $program,
            'title' => 'Program Records'
        ]);

        return $pdf->download('program_records_' . now()->format('Y-m-d') . '.pdf');
    }
}

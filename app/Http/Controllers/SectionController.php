<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Section::with('program');

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('section_name', 'like', "%{$search}%")
                ->orWhereHas('program', function ($q) use ($search) {
                    $q->where('program_name', 'like', "%{$search}%");
                });
        }

        $sections = $query->latest()->paginate(10);

        return view('sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = Program::all();
        return view('sections.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_name' => 'required|string|max:20|unique:sections',
            'program_id' => 'required|exists:programs,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Section::create([
            'section_name' => $request->section_name,
            'program_id' => $request->program_id,
        ]);

        return redirect()->route('sections.index')
            ->with('success', 'Section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        $section->load('program');
        return view('sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        $programs = Program::all();
        return view('sections.edit', compact('section', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validator = Validator::make($request->all(), [
            'section_name' => 'required|string|max:20|unique:sections,section_name,' . $section->id,
            'program_id' => 'required|exists:programs,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $section->update([
            'section_name' => $request->section_name,
            'program_id' => $request->program_id,
        ]);

        return redirect()->route('sections.index')
            ->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->route('sections.index')
            ->with('success', 'Section deleted successfully.');
    }

    /**
     * Export sections to PDF.
     */
    public function exportPdf()
    {
        $section = Section::all();

        $pdf = PDF::loadView('sections.pdf', [
            'sections' => $section,
            'title' => 'Section Records'
        ]);

        return $pdf->download('section_records_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Get sections by program ID (for AJAX)
     */
    public function getSectionsByProgram(Request $request)
    {
        \Log::info('SectionController::getSectionsByProgram called', [
            'program_id' => $request->program_id,
            'user' => auth()->user(),
            'request_data' => $request->all()
        ]);

        try {
            $request->validate([
                'program_id' => 'required|exists:programs,id'
            ]);

            $programId = $request->program_id;

            $sections = Section::where('program_id', $programId)
                ->orderBy('section_name')
                ->get();

            \Log::info('Sections found', [
                'program_id' => $programId,
                'count' => $sections->count(),
                'sections' => $sections->toArray()
            ]);

            return response()->json($sections);
        } catch (\Exception $e) {
            \Log::error('Error in getSectionsByProgram', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export individual section to PDF
     */
    public function exportIndividualPdf(Section $section)
    {
        $section->load('program');

        $pdf = PDF::loadView('sections.individual-pdf', [
            'section' => $section,
            'title' => 'Section Record'
        ]);

        return $pdf->download('section_record_' . $section->id . '_' . now()->format('Y-m-d') . '.pdf');
    }
}

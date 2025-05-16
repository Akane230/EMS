<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Term::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('schoolyear_semester', 'like', "%{$search}%");
        }

        $terms = $query->orderBy('start_date', 'desc')->paginate(10);

        return view('terms.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('terms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schoolyear_semester' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Term::create($validated);

        return redirect()->route('terms.index')
            ->with('success', 'Term created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $term)
    {
        return view('terms.show', compact('term'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term)
    {
        return view('terms.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Term $term)
    {
        $validated = $request->validate([
            'schoolyear_semester' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $term->update($validated);

        return redirect()->route('terms.index')
            ->with('success', 'Term updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Term $term)
    {
        $term->delete();

        return redirect()->route('terms.index')
            ->with('success', 'Term deleted successfully.');
    }

    /**
     * Export terms to PDF.
     */
    public function exportPdf()
    {
        $terms = Term::all();

        $pdf = PDF::loadView('terms.pdf', [
            'terms' => $terms,
            'title' => 'Academic Terms Records'
        ]);

        return $pdf->download('term_records_' . now()->format('Y-m-d') . '.pdf');
    }
}

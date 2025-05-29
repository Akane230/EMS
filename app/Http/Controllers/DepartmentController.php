<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $departments = Department::when($search, function ($query, $search) {
            return $query->where('id', 'like', "%{$search}%")
                ->orWhere('department_name', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|string|max:100|unique:departments',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('departments.create')
                ->withErrors($validator)
                ->withInput();
        }

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|string|max:100|unique:departments,department_name,' . $department->id,
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('departments.edit', $department)
                ->withErrors($validator)
                ->withInput();
        }

        $department->update($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function exportPdf()
    {
        $department = Department::all();

        $pdf = PDF::loadView('departments.pdf', [
            'departments' => $department,
            'title' => 'Department Records'
        ]);

        return $pdf->download('department_records_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export individual department to PDF
     */
    public function exportIndividualPdf(Department $department)
    {
        $pdf = PDF::loadView('departments.individual-pdf', [
            'department' => $department,
            'title' => 'Department Record'
        ]);

        return $pdf->download('department_record_' . $department->id . '_' . now()->format('Y-m-d') . '.pdf');
    }
}

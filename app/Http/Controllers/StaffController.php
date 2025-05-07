<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $staff = Staff::when($search, function ($query, $search) {
            return $query->where('staff_id', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('staff.index', compact('staff'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|unique:staff',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:staff',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'country' => 'nullable',
            'province' => 'nullable',
            'city' => 'nullable',
            'street' => 'nullable',
            'zipcode' => 'nullable',
            'contact_number' => 'nullable',
        ]);

        Staff::create($request->all());

        return redirect()->route('staff.index')
            ->with('success', 'Staff created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'staff_id' => 'required|unique:staff,staff_id,' . $staff->staff_id . ',staff_id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:staff,email,' . $staff->staff_id . ',staff_id',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'country' => 'nullable',
            'province' => 'nullable',
            'city' => 'nullable',
            'street' => 'nullable',
            'zipcode' => 'nullable',
            'contact_number' => 'nullable',
        ]);

        $staff->update($request->all());

        return redirect()->route('staff.index')
            ->with('success', 'Staff updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\StudentSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class StudentProfileController extends Controller
{
    /**
     * Show the student profile edit form
     */
    public function edit()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            return redirect()->route('studentSide.dashboard')
                ->with('error', 'Student profile not found.');
        }

        return view('studentSide.profile.edit', compact('student'));
    }

    /**
     * Update the student profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('studentSide.dashboard')
                ->with('error', 'Student profile not found.');
        }

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . '|unique:students,email,' . $student->id,
            'contact_number' => 'required|string|max:15',
            'country' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ];

        // Add password validation if any password field is filled
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $rules['current_password'] = 'required|current_password';
            $rules['new_password'] = ['required', 'confirmed', Password::min(8)];
        }

        $validated = $request->validate($rules);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        // Update student information
        $student->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'],
            'country' => $validated['country'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'street' => $validated['street'],
            'zipcode' => $validated['zipcode'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
        ]);

        // Update user information
        $userUpdateData = [
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ];

        // Add avatar to user update if uploaded
        if (isset($validated['avatar'])) {
            $userUpdateData['avatar'] = $validated['avatar'];
        }

        $user->update($userUpdateData);

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->update(['password' => Hash::make($validated['new_password'])]);
        }

        return redirect()->route('studentSide.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the student profile (read-only view)
     */
    public function show()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            return redirect()->route('studentSide.dashboard')
                ->with('error', 'Student profile not found.');
        }

        return view('studentSide.profile.show', compact('student'));
    }
}
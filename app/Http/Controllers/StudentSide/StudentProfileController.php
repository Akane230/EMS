<?php

namespace App\Http\Controllers\StudentSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function update(Request $request)
    {
        $student = auth()->user();

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'contact_number' => 'required|string|max:15',
            'country' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'zipcode' => 'required|string|max:10',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ];

        // Add program validation if student doesn't have a program yet
        if (!$student->program_id) {
            $rules['program_id'] = 'required|exists:programs,id';
        }

        // Add password validation if any password field is filled
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $rules['current_password'] = 'required|current_password';
            $rules['new_password'] = 'required|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($student->avatar) {
                Storage::delete($student->avatar);
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
            'avatar' => $validated['avatar'] ?? $student->avatar,
        ]);

        // Update program if provided
        if (isset($validated['program_id'])) {
            $student->update(['program_id' => $validated['program_id']]);
        }

        // Update password if provided
        if ($request->filled('new_password')) {
            $student->update(['password' => Hash::make($validated['new_password'])]);
        }

        return redirect()->route('studentSide.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}

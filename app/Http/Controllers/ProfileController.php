<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */

     public function update(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
             'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'remove_avatar' => 'nullable|boolean'
         ]);
         
         /** @var \App\Models\User $user */
         $user = Auth::user();
         $user->name = $request->name;
         $user->email = $request->email;
         
         if ($request->has('remove_avatar') && $request->remove_avatar == true) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
                $user->avatar = null;
            }
         } elseif ($request->hasFile('avatar')) {
             if ($user->avatar) {
                 Storage::disk('public')->delete($user->avatar);
             }
             $avatarPath = $request->file('avatar')->store('avatars', 'public');
             $user->avatar = $avatarPath;
         }
         
         $user->save();
         
         // Change from 'success' to 'status' => 'profile-updated' to match the blade check
         return redirect()->back()->with('status', 'profile-updated');
     }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

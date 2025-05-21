<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Custom redirect based on role
        if ($user->role === 'Admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'Student') {
            // If user is a student but doesn't have a student record, redirect to profile
            if (!$user->student) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Please complete your student profile before accessing the dashboard.');
            }
            return redirect()->intended(route('studentSide.dashboard'));
        } elseif ($user->role === 'Instructor') {
            return redirect()->intended(route('instructor.dashboard'));
        }

        // Default redirect for other roles
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

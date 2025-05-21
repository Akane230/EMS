<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Debug information
        \Log::info('Role Check', [
            'user_id' => $request->user()->id,
            'user_role' => $request->user()->role,
            'required_role' => $role,
            'path' => $request->path()
        ]);

        if ($request->user()->role !== $role) {
            return $this->handleWrongRole($request);
        }

        return $next($request);
    }

    protected function handleWrongRole($request)
    {
        \Log::info('Wrong Role Access', [
            'user_id' => $request->user()->id,
            'user_role' => $request->user()->role,
            'path' => $request->path()
        ]);

        if ($request->user()->role === 'Student') {
            return redirect()->route('studentSide.dashboard');
        }

        if ($request->user()->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }

        // If we get here, the user has a role that doesn't match any known role
        abort(403, 'Unauthorized access');
    }
}

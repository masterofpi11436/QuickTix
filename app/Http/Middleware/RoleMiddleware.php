<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage: ->middleware(['role:Administrator'])
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        // If user isn't logged in
        if (! $user) {
            return redirect()->route('login')
                ->with('status', 'Please log in to continue.');
        }

        // If user's role isn't allowed
        if (! in_array($user->role->value, $roles)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('status', 'Unauthorized access. You have been logged out.');
        }

        return $next($request);
    }
}

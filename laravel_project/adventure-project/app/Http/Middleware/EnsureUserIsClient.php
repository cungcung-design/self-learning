<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsClient
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->isAdmin()) {
            return $next($request);
        }

        // Admins should use the admin dashboard
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        abort(403, 'Unauthorized. User access required.');
    }
}


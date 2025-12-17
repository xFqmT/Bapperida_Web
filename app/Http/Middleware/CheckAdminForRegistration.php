<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminForRegistration
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not authenticated, redirect to login
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        // If user is not admin, deny access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only administrators can access user registration.');
        }
        
        return $next($request);
    }
}

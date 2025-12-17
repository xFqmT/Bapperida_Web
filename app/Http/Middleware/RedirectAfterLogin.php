<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAfterLogin
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Redirect based on user role
            if ($user->role === 'admin') {
                return redirect('/dashboard');
            } else {
                return redirect('/meetings');
            }
        }
        
        return $response;
    }
}

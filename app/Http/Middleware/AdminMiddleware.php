<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
           // Check if the user is authenticated and has the role "Admin"
           if (Auth::check() && Auth::user()->role->role === 'admin') {
            return $next($request);
        }

        // Redirect if the user does not have the admin role
        return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
    
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // If not logged in, redirect to login page
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if the user has the required role
        if (Auth::user()->role !== $role) {
            // Redirect user to their own dashboard based on role
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'parent':
                    return redirect('/parent/dashboard');
                case 'bhw':
                    return redirect('/bhw/dashboard');
                case 'bns':
                    return redirect('/bns/dashboard');
                case 'rhu':
                    return redirect('/rhu/dashboard');
                default:
                    return redirect('/login'); // fallback
            }
        }

        // Otherwise continue
        return $next($request);
    }
}

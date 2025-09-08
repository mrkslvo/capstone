<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RedirectIfAuthenticatedWithRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if route exists
        if (!Route::has($request->route()?->getName())) {
            // Redirect to custom page if route not found
            return redirect('/not-found'); // Or any route you want
        }

        return $next($request);
    }
}

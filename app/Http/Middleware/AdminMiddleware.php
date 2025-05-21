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
        if (Auth::check() && Auth::user()->role === 'admin') { // Ensure 'role' is the correct column name
            return $next($request);
        }

        // Redirect non-admin users or return an unauthorized response
        // You can redirect them to the home page or show a 403 error
        // abort(403, 'Unauthorized action.');
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}

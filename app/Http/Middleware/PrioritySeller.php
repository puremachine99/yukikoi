<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrioritySeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isPrioritySeller()) {
            return $next($request);
        }
        return redirect()->route('subscription.page')->with('error', 'Anda harus berlangganan untuk mengakses fitur ini.');
    }
}

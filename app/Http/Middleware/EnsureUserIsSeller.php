<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user adalah seller
        if (!auth()->user()->is_seller) {
            return redirect()->route('profile.edit')->with('error', 'Anda harus mendaftar sebagai seller untuk membuat lelang.');
        }

        return $next($request);
    }
}

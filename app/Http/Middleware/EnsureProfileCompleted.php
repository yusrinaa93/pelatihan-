<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum melengkapi profil, redirect ke account
        if (auth()->check() && !auth()->user()->profile_completed) {
            return redirect()
                ->route('account')
                ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu sebelum mendaftar pelatihan.');
        }

        return $next($request);
    }
}

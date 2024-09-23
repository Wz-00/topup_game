<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Jika pengguna belum login, izinkan akses (guest)
        if (!Auth::check()) {
            return $next($request);
        }

        // Jika pengguna sudah login dan role-nya adalah member, izinkan akses
        if (Auth::user()->role === 'member') {
            return $next($request);
        }

        // Jika pengguna login tapi bukan member, batasi akses atau redirect
        return redirect('/login')->withErrors(['Anda tidak memiliki izin untuk mengakses halaman ini']);
    }
}

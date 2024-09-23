<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check()) {
            if (Auth::user()->role === $role) {
                return $next($request);
            } else {
                return redirect()->route('user.home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        } else {
            return redirect()->route('user.home')->with('error', 'Silakan login terlebih dahulu.');
        }
    }
}

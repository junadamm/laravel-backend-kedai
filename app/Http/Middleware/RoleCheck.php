<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        // Ambil role dari user yang sedang login
        // $userRole = auth()->check() ? auth()->user()->role : null;  // pastikan roles diambil dari user

        $userRole = auth()->check() ? auth()->user()->$allowedRoles : null;

        // Cek apakah role user sesuai dengan salah satu role yang diizinkan
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

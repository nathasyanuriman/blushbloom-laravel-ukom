<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        if (session('user_role') !== $role) {
            $redirectRoute = session('user_role') === 'admin' ? 'admin.dashboard' : 'dashboard';
            
            return redirect()->route($redirectRoute)->with('error', 'Kamu tidak memiliki akses ke halaman itu.');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        $user = Auth::guard($guard)->user();

        if ($user) {
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('super-admin.dashboard');
                case 'lawyer':
                    return redirect()->route('dashboard');
                case 'user':
                    return redirect()->route('home');
                default:
                    abort(403, 'Unauthorized');
            }
        }

        return $next($request);
    }
}

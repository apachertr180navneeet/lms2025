<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            $user = Auth::user();

            // Prefer Spatie's role check if available
            if (method_exists($user, 'hasRole') ? $user->hasRole('admin') : ($user->role == 'admin')) {
                return $next($request);
            }

            return redirect()->back();
        }

        return redirect()->route('admin.login');
    }
}

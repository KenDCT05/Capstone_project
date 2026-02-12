<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Allow access if no user is authenticated
        if (!$user) {
            return $next($request);
        }

        // Skip check for admins
        if ($user->role === 'admin') {
            return $next($request);
        }

        // If user still has first_login = true, force them to change password
        if ($user->first_login) {
            // Allow access only to password change routes and logout
            if (!$request->routeIs('change-password.edit') && 
                !$request->routeIs('change-password.update') && 
                !$request->routeIs('logout')) {
                
                return redirect()->route('change-password.edit')
                    ->with('info', 'You must change your default password before accessing the system.');
            }
        }

        return $next($request);
    }
}
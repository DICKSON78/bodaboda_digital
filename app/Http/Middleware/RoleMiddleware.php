<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Unauthenticated.');
        }
        
        // Check if user has the required role
        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized action. Required role: ' . $role . ', Current role: ' . auth()->user()->role);
        }
        
        return $next($request);
    }
}

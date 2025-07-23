<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            abort(401, 'Unauthenticated');
        }

        if (!auth()->user()->hasRole($role)) {
            abort(403, "You don't have the required {$role} role");
        }

        return $next($request);
    }
}
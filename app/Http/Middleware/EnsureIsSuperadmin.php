<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsSuperadmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has superadmin role
        if (!$request->user() || !$request->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
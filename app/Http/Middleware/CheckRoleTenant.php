<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle($request, Closure $next)
{
    $roleId = $request->route('role');
    
    if ($roleId) {
        $role = \Spatie\Permission\Models\Role::findOrFail($roleId);
        
        if ($role->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Accès non autorisé à ce rôle.');
        }
    }
    
    return $next($request);
}
}
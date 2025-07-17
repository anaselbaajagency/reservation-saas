<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Gère une requête entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles  Les rôles autorisés (admin, user, etc.)
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Vérifie si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();

        // Vérifie si l'utilisateur a l'un des rôles autorisés
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Accès refusé
        abort(403, 'Accès non autorisé');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Verifica que el usuario tenga uno de los roles permitidos.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Usuario no autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $usuario = auth()->user();

        // Usuario sin rol
        if (!$usuario->rol) {
            abort(403, 'El usuario no tiene un rol asignado.');
        }

        // Verificar si el rol del usuario está permitido
        if (!in_array($usuario->rol->nombre, $roles)) {
            abort(403, 'No tienes autorización para acceder a esta sección.');
        }

        return $next($request);
    }
}
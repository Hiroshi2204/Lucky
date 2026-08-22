<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureLocalSelected
{
    /**
     * Verifica que el usuario tenga un local activo
     * y que realmente tenga acceso a dicho local.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        /** @var \App\User $usuario */
        $usuario = auth()->user();
        $localId = session('local_id');

        // No existe local seleccionado
        if (!$localId) {
            return redirect()->route('local.seleccionar');
        }

        // Verificar que el usuario siga teniendo acceso al local
        $tieneAcceso = $usuario->locales()
            ->where('locales.id', $localId)
            ->where('locales.estado', true)
            ->where('usuario_local.estado', true)
            ->exists();

        if (!$tieneAcceso) {
            session()->forget('local_id');

            return redirect()
                ->route('local.seleccionar')
                ->withErrors([
                    'local_id' => 'El local seleccionado ya no está disponible para tu usuario.'
                ]);
        }

        return $next($request);
    }
}
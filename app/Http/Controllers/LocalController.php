<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    /**
     * Mostrar los locales disponibles para el usuario.
     */
    public function seleccionar()
    {
        /** @var User $usuario */
        $usuario = auth()->user();

        $locales = $usuario->locales()
            ->where('locales.estado', true)
            ->where('usuario_local.estado', true)
            ->orderBy('locales.nombre')
            ->get();

        if ($locales->isEmpty()) {
            auth()->logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'username' => 'El usuario no tiene ningún local asignado.'
                ]);
        }

        /*
         * Si solamente tiene un local,
         * se asigna automáticamente.
         */
        if ($locales->count() === 1) {

            session([
                'local_id' => $locales->first()->id,
            ]);

            return redirect()->route('dashboard');
        }

        return view('locales.seleccionar', compact('locales'));
    }

    /**
     * Guardar el local seleccionado.
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'local_id' => [
                'required',
                'integer',
            ],
        ]);

        /** @var User $usuario */
        $usuario = auth()->user();

        /*
         * Verificamos que el usuario tenga
         * realmente acceso al local.
         */
        $local = $usuario->locales()
            ->where('locales.id', $request->local_id)
            ->where('locales.estado', true)
            ->where('usuario_local.estado', true)
            ->first();

        if (!$local) {
            return back()
                ->withErrors([
                    'local_id' => 'No tienes autorización para acceder a este local.'
                ])
                ->withInput();
        }

        session([
            'local_id' => $local->id,
            'local_nombre' => $local->nombre,
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Cambiar de local durante la sesión.
     */
    public function cambiar()
    {
        session()->forget('local_id');

        return redirect()->route('local.seleccionar');
    }
}
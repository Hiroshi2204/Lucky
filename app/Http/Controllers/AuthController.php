<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostrar login
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    /**
     * Autenticar usuario
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ], [
            'username.required' => 'Ingrese su usuario.',
            'password.required' => 'Ingrese su contraseña.',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'estado_registro' => true,
        ];

        if (!Auth::attempt($credentials)) {

            return back()
                ->withErrors([
                    'username' => 'Usuario o contraseña incorrectos.',
                ])
                ->withInput(
                    $request->only('username')
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerar sesión
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        /** @var \App\User $user */
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        |
        | El administrador puede tener varios locales.
        | Por eso NO asignamos automáticamente un local.
        |
        */

        if ($user->rol_id == 1) {

            $locales = $user->locales()
                ->where('locales.estado', true)
                ->wherePivot('estado', true)
                ->get();

            if ($locales->isEmpty()) {

                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors([
                        'username' =>
                            'El administrador no tiene ningún local asignado.'
                    ]);
            }

            /*
             * Si solamente tiene un local,
             * podemos seleccionarlo automáticamente.
             */

            if ($locales->count() === 1) {

                $request->session()->put(
                    'local_id',
                    $locales->first()->id
                );

                return redirect()->intended(
                    route('dashboard')
                );
            }

            /*
             * Si tiene varios locales,
             * debe seleccionar uno.
             */

            return redirect()->route('local.seleccionar');
        }

        /*
        |--------------------------------------------------------------------------
        | TRABAJADOR
        |--------------------------------------------------------------------------
        |
        | El trabajador NO selecciona local.
        | Se obtiene automáticamente desde usuario_local.
        |
        */

        if ($user->rol_id == 2) {

            $local = $user->locales()
                ->where('locales.estado', true)
                ->wherePivot('estado', true)
                ->first();

            if (!$local) {

                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors([
                        'username' =>
                            'El usuario no tiene un local asignado.'
                    ]);
            }

            /*
             * Guardamos automáticamente
             * el local del trabajador.
             */

            $request->session()->put(
                'local_id',
                $local->id
            );

            return redirect()->intended(
                route('dashboard')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rol desconocido
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()
            ->withErrors([
                'username' =>
                    'El usuario no tiene un rol válido.'
            ]);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->forget('local_id');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Sesión cerrada correctamente.'
            );
    }

    /**
     * Usuario autenticado
     */
    public function my()
    {
        $user = User::with([
            'persona',
            'rol',
            'locales'
        ])->find(Auth::id());

        if (!$user) {

            return response()->json([
                'error' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $user->id,
                'persona_id' => $user->persona_id,
                'username' => $user->username,
                'rol' => $user->rol,
                'persona' => $user->persona,
                'locales' => $user->locales,
                'local_id' => session('local_id'),
            ]
        ]);
    }
}
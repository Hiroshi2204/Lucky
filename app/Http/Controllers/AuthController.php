<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            /** @var \App\User $user */
            $user = Auth::user();

            if ($user->mustChangePassword) {
                return redirect()->route('password.change');
            }

            return redirect()->route('dashboard');
        }

        return view('login');
    }

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
                ->withInput($request->only('username'));
        }

        $request->session()->regenerate();

        /** @var \App\User $user */
        $user = Auth::user();

        if ($user->mustChangePassword) {
            return redirect()
                ->route('password.change')
                ->with(
                    'warning',
                    'Por seguridad, debe cambiar su contraseña antes de continuar.'
                );
        }

        return $this->continuarDespuesDelLogin($request, $user);
    }

    /**
     * Completa el acceso al sistema después del login o del cambio
     * obligatorio de contraseña.
     */
    public function continuarDespuesDelLogin(Request $request, ?User $user = null)
    {
        /** @var \App\User $user */
        $user = $user ?: Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
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

                return redirect()->route('login')
                    ->withErrors([
                        'username' =>
                        'El administrador no tiene ningún local asignado.'
                    ]);
            }

            if ($locales->count() === 1) {

                $request->session()->put(
                    'local_id',
                    $locales->first()->id
                );

                return redirect()->intended(
                    route('dashboard')
                );
            }

            return redirect()->route('local.seleccionar');
        }

        /*
        |--------------------------------------------------------------------------
        | TRABAJADOR
        |--------------------------------------------------------------------------
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

                return redirect()->route('login')
                    ->withErrors([
                        'username' =>
                        'El usuario no tiene un local asignado.'
                    ]);
            }

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
        | ROL DESCONOCIDO
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->withErrors([
                'username' =>
                'El usuario no tiene un rol válido.'
            ]);
    }

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

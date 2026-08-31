<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:7',
                'confirmed',
            ],
        ], [
            'password.required' =>
            'Ingrese su nueva contraseña.',

            'password.min' =>
            'La contraseña debe tener mínimo 7 caracteres.',

            'password.confirmed' =>
            'Las contraseñas no coinciden.',
        ]);

        /** @var \App\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | NO PERMITIR MANTENER LA CONTRASEÑA TEMPORAL
        |--------------------------------------------------------------------------
        */

        if (Hash::check($request->password, $user->password)) {

            return back()
                ->withErrors([
                    'password' =>
                    'La nueva contraseña debe ser diferente a la contraseña temporal actual.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | GUARDAR NUEVA CONTRASEÑA
        |--------------------------------------------------------------------------
        */

        $user->password = $request->password;
        $user->must_change_password = false;
        $user->save();

        $request->session()->forget('local_id');

        return app(AuthController::class)
            ->continuarDespuesDelLogin($request, $user);
    }
}

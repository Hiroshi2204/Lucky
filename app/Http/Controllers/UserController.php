<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Local;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = User::with([
            'persona',
            'rol',
            'locales'
        ])
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $usuarios
            ]);
        }

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $locales = Local::where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'usuarios.create',
            compact('locales')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_documento' => [
                'required',
                'string',
                'max:20'
            ],
            'nombres' => [
                'required',
                'string',
                'max:100'
            ],
            'apellido_paterno' => [
                'required',
                'string',
                'max:100'
            ],
            'apellido_materno' => [
                'nullable',
                'string',
                'max:100'
            ],
            'celular' => [
                'nullable',
                'string',
                'max:20'
            ],
            'correo' => [
                'nullable',
                'email',
                'max:150'
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed'
            ],
            'local_id' => [
                'required',
                'exists:locales,id'
            ],
        ], [
            'numero_documento.required' =>
            'El número de documento es obligatorio.',
            'nombres.required' =>
            'Los nombres son obligatorios.',
            'apellido_paterno.required' =>
            'El apellido paterno es obligatorio.',
            'username.required' =>
            'El nombre de usuario es obligatorio.',
            'username.unique' =>
            'El nombre de usuario ya está registrado.',
            'password.required' =>
            'La contraseña es obligatoria.',
            'password.min' =>
            'La contraseña debe tener mínimo 6 caracteres.',
            'password.confirmed' =>
            'Las contraseñas no coinciden.',
            'local_id.required' =>
            'Debe seleccionar un local.',
            'local_id.exists' =>
            'El local seleccionado no existe.',
        ]);

        try {

            $resultado = DB::transaction(function () use ($validated) {

                $persona = Persona::where(
                    'numero_documento',
                    $validated['numero_documento']
                )
                    ->lockForUpdate()
                    ->first();

                if (!$persona) {

                    $persona = Persona::create([
                        'tipo_documento_id' => 1,
                        'numero_documento' =>
                        $validated['numero_documento'],
                        'nombres' =>
                        $validated['nombres'],
                        'apellido_paterno' =>
                        $validated['apellido_paterno'],
                        'apellido_materno' =>
                        $validated['apellido_materno'] ?? null,
                        'celular' =>
                        $validated['celular'] ?? null,
                        'correo' =>
                        $validated['correo'] ?? null,
                    ]);
                } else {

                    if ($persona->user) {

                        throw new \Exception(
                            'La persona ya tiene un usuario registrado.'
                        );
                    }
                }

                $rolTrabajador = \App\Models\Rol::where(
                    'nombre',
                    'TRABAJADOR'
                )->first();

                if (!$rolTrabajador) {

                    throw new \Exception(
                        'No existe el rol TRABAJADOR en la base de datos.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | CREAR USUARIO CON CONTRASEÑA TEMPORAL
                |--------------------------------------------------------------------------
                */

                $usuario = User::create([
                    'persona_id' =>
                    $persona->id,

                    'username' =>
                    $validated['username'],

                    'password' =>
                    $validated['password'],

                    'rol_id' =>
                    $rolTrabajador->id,

                    'estado_registro' =>
                    true,

                    'must_change_password' =>
                    true,
                ]);

                $usuario->locales()->attach(
                    $validated['local_id'],
                    [
                        'estado' => true
                    ]
                );

                return $usuario;
            });

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => true,
                    'message' =>
                    'Trabajador creado y local asignado correctamente. La contraseña entregada es temporal y deberá cambiarla al ingresar.',
                    'data' =>
                    $resultado->load([
                        'persona',
                        'rol',
                        'locales'
                    ])
                ], 201);
            }

            return redirect()
                ->route('usuarios.index')
                ->with(
                    'success',
                    'Trabajador creado y local asignado correctamente. La contraseña entregada es temporal y deberá cambiarla al ingresar.'
                );
        } catch (\Throwable $e) {

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' =>
                    'No se pudo crear el trabajador.',
                    'error' =>
                    $e->getMessage()
                ], 422);
            }

            return back()
                ->withInput()
                ->withErrors([
                    'usuario' =>
                    $e->getMessage()
                ]);
        }
    }

    public function edit(User $usuario)
    {
        if ((int) $usuario->rol_id === 1) {

            return back()->withErrors([
                'usuario' =>
                'No se puede editar un administrador.'
            ]);
        }

        $usuario->load([
            'persona',
            'rol',
            'locales'
        ]);

        $locales = Local::where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'usuarios.edit',
            compact(
                'usuario',
                'locales'
            )
        );
    }

    public function update(Request $request, User $usuario)
    {
        if ((int) $usuario->rol_id === 1) {

            return back()->withErrors([
                'usuario' =>
                'No se puede editar un administrador.'
            ]);
        }

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username,' . $usuario->id
            ],
            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed'
            ],
            'local_id' => [
                'required',
                'exists:locales,id'
            ],
        ], [
            'username.required' =>
            'El nombre de usuario es obligatorio.',
            'username.unique' =>
            'El nombre de usuario ya está registrado.',
            'password.min' =>
            'La contraseña debe tener mínimo 6 caracteres.',
            'password.confirmed' =>
            'Las contraseñas no coinciden.',
            'local_id.required' =>
            'Debe seleccionar un local.',
            'local_id.exists' =>
            'El local seleccionado no existe.',
        ]);

        try {

            DB::transaction(function () use (
                $validated,
                $usuario
            ) {

                $datos = [
                    'username' =>
                    $validated['username'],
                ];

                /*
                |--------------------------------------------------------------------------
                | RESET DE CONTRASEÑA POR ADMINISTRADOR
                |--------------------------------------------------------------------------
                |
                | Si el administrador establece una nueva contraseña,
                | esa contraseña vuelve a ser temporal.
                |
                */

                if (!empty($validated['password'])) {

                    $datos['password'] =  $validated['password'];

                    $datos['must_change_password'] =
                        true;
                }

                $usuario->update($datos);

                $usuario->locales()->sync([
                    $validated['local_id'] => [
                        'estado' => true
                    ]
                ]);
            });

            return redirect()
                ->route('usuarios.index')
                ->with(
                    'success',
                    !empty($validated['password'])
                        ? 'Usuario, contraseña temporal y local actualizados correctamente. El trabajador deberá cambiar la contraseña al ingresar.'
                        : 'Usuario y local actualizados correctamente.'
                );
        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->withErrors([
                    'usuario' =>
                    'No se pudo actualizar el usuario.'
                ]);
        }
    }

    public function cambiarEstado(User $usuario)
    {
        if ((int) $usuario->rol_id === 1) {

            return back()->withErrors([
                'usuario' =>
                'No se puede desactivar un administrador.'
            ]);
        }

        $usuario->update([
            'estado_registro' =>
            !$usuario->estado_registro
        ]);

        return back()->with(
            'success',
            $usuario->estado_registro
                ? 'Trabajador activado correctamente.'
                : 'Trabajador desactivado correctamente.'
        );
    }
}

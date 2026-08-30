@extends('layouts.app')

@section('title', 'Usuarios')

@section('styles')

<style>
    .usuarios-container {
        width: 100%;
    }

    /* HEADER */

    .usuarios-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .usuarios-header h1 {
        font-size: 28px;
        color: #1f2937;
        margin: 0;
    }

    .usuarios-header p {
        margin-top: 6px;
        color: #6b7280;
        font-size: 14px;
    }

    .btn-crear {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        padding: 11px 17px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-crear:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }


    /* MENSAJES */

    .alert {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }


    /* CARD */

    .usuarios-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }


    /* TABLA */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .usuarios-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .usuarios-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 13px 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
    }

    .usuarios-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #374151;
        vertical-align: middle;
    }

    .usuarios-table tbody tr:hover {
        background: #f8fafc;
    }


    /* NOMBRE */

    .usuario-nombre {
        font-weight: 600;
        color: #1f2937;
    }

    .usuario-documento {
        color: #6b7280;
        font-size: 12px;
        margin-top: 3px;
    }


    /* ESTADOS */

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-activo {
        background: #dcfce7;
        color: #166534;
    }

    .badge-inactivo {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-rol {
        background: #eff6ff;
        color: #1d4ed8;
    }


    /* LOCALES */

    .local-badge {
        display: inline-block;
        background: #f3f4f6;
        color: #374151;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 12px;
        margin: 2px;
    }


    /* BOTÓN ESTADO */

    .btn-estado {
        border: 0;
        padding: 7px 11px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .btn-desactivar {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-desactivar:hover {
        background: #fecaca;
    }

    .btn-activar {
        background: #dcfce7;
        color: #166534;
    }

    .btn-activar:hover {
        background: #bbf7d0;
    }

    .admin-text {
        color: #6b7280;
        font-size: 12px;
    }


    /* PAGINACIÓN */

    .usuarios-pagination {
        margin-top: 20px;
    }


    /* RESPONSIVE */

    @media(max-width: 700px) {

        .usuarios-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .usuarios-header h1 {
            font-size: 24px;
        }

        .btn-crear {
            width: 100%;
            justify-content: center;
        }

        .usuarios-card {
            padding: 12px;
        }

    }

    .btn-editar {
        background: #dbeafe;
        color: #1d4ed8;
        text-decoration: none;
    }

    .btn-editar:hover {
        background: #bfdbfe;
    }
</style>

@endsection


@section('content')

<div class="usuarios-container">


    {{-- HEADER --}}

    <div class="usuarios-header">

        <div>

            <h1>
                Usuarios
            </h1>

            <p>
                Administración de trabajadores del sistema
            </p>

        </div>


        <a
            href="{{ route('usuarios.create') }}"
            class="btn-crear">

            <span>＋</span>

            Crear trabajador

        </a>

    </div>


    {{-- MENSAJE ÉXITO --}}

    @if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

    @endif


    {{-- ERRORES --}}

    @if($errors->any())

    <div class="alert alert-error">

        {{ $errors->first() }}

    </div>

    @endif


    {{-- TABLA --}}

    <div class="usuarios-card">

        <div class="table-wrapper">

            <table class="usuarios-table">

                <thead>

                    <tr>

                        <th>
                            Documento
                        </th>

                        <th>
                            Trabajador
                        </th>

                        <th>
                            Usuario
                        </th>

                        <th>
                            Rol
                        </th>

                        <th>
                            Local
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Acción
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($usuarios as $usuario)

                    <tr>


                        {{-- DOCUMENTO --}}

                        <td>

                            <strong>
                                {{ $usuario->persona->numero_documento ?? '-' }}
                            </strong>

                        </td>


                        {{-- TRABAJADOR --}}

                        <td>

                            <div class="usuario-nombre">

                                {{ $usuario->persona->nombres ?? '' }}

                                {{ $usuario->persona->apellido_paterno ?? '' }}

                                {{ $usuario->persona->apellido_materno ?? '' }}

                            </div>

                        </td>


                        {{-- USUARIO --}}

                        <td>

                            {{ $usuario->username }}

                        </td>


                        {{-- ROL --}}

                        <td>

                            @if($usuario->rol_id == 1)

                            <span class="badge badge-rol">
                                Administrador
                            </span>

                            @else

                            <span class="badge badge-rol">
                                Trabajador
                            </span>

                            @endif

                        </td>


                        {{-- LOCAL --}}

                        <td>

                            @forelse($usuario->locales as $local)

                            <span class="local-badge">

                                {{ $local->nombre }}

                            </span>

                            @empty

                            <span class="admin-text">
                                Sin local
                            </span>

                            @endforelse

                        </td>


                        {{-- ESTADO --}}

                        <td>

                            @if($usuario->estado_registro)

                            <span class="badge badge-activo">
                                Activo
                            </span>

                            @else

                            <span class="badge badge-inactivo">
                                Inactivo
                            </span>

                            @endif

                        </td>


                        {{-- ACCIÓN --}}

                        <td>

                            @if($usuario->rol_id != 1)

                            <div style="display:flex; gap:7px; align-items:center;">

                                {{-- EDITAR --}}
                                <a
                                    href="{{ route('usuarios.edit', $usuario) }}"
                                    class="btn-estado btn-editar">

                                    Editar

                                </a>


                                {{-- ACTIVAR / DESACTIVAR --}}
                                <form
                                    method="POST"
                                    action="{{ route(
                                    'usuarios.estado',
                                    $usuario
                                ) }}">

                                    @csrf

                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn-estado
                                        {{ $usuario->estado_registro
                                            ? 'btn-desactivar'
                                            : 'btn-activar' }}">

                                        {{ $usuario->estado_registro
                                        ? 'Desactivar'
                                        : 'Activar' }}

                                    </button>

                                </form>

                            </div>

                            @else

                            <span class="admin-text">
                                Protegido
                            </span>
                            

                            @endif

                        </td>

                    </tr>


                    @empty

                    <tr>

                        <td
                            colspan="7"
                            style="text-align:center;padding:40px;">

                            No hay usuarios registrados.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}

        @if($usuarios->hasPages())

        <div class="usuarios-pagination">

            {{ $usuarios->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
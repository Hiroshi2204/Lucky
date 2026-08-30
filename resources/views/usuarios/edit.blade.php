@extends('layouts.app')

@section('title', 'Editar usuario - Macrotechos')

@section('styles')

<style>
    .editar-container {
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
    }

    .editar-header {
        margin-bottom: 25px;
    }

    .editar-header h1 {
        font-size: 28px;
        color: #1f2937;
        margin: 0;
    }

    .editar-header p {
        margin-top: 6px;
        color: #6b7280;
        font-size: 14px;
    }

    .editar-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }

    .usuario-info {
        background: #f8fafc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 25px;
    }

    .usuario-info strong {
        color: #1f2937;
    }

    .usuario-info span {
        color: #64748b;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: .2s;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .form-group input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .form-help {
        margin-top: 6px;
        color: #6b7280;
        font-size: 12px;
    }

    .alert {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        border: 0;
        padding: 11px 17px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: .2s;
    }

    .btn-cancelar {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-cancelar:hover {
        background: #e5e7eb;
    }

    .btn-guardar {
        background: #2563eb;
        color: white;
    }

    .btn-guardar:hover {
        background: #1d4ed8;
    }

    @media(max-width: 600px) {

        .editar-card {
            padding: 18px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            text-align: center;
        }

    }

    /* =====================================================
   CONTRASEÑA
===================================================== */

    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        padding-right: 45px !important;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        font-size: 16px;
        padding: 4px;
    }

    .password-toggle:hover {
        color: #2563eb;
    }


    /* REQUISITOS */

    .password-requirements {
        margin-top: 8px;
        padding: 9px 12px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .password-requirement {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        color: #6b7280;
    }

    .password-requirement.valid {
        color: #15803d;
    }

    .password-requirement.invalid {
        color: #dc2626;
    }

    .requirement-icon {
        width: 14px;
        font-weight: bold;
    }


    /* COINCIDENCIA */

    .password-match {
        margin-top: 7px;
        font-size: 12px;
        min-height: 16px;
    }

    .password-match.valid {
        color: #15803d;
    }

    .password-match.invalid {
        color: #dc2626;
    }


    /* INPUT */

    .password-error {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .08) !important;
    }

    .password-success {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, .08) !important;
    }
</style>

@endsection


@section('content')

<div class="editar-container">

    {{-- HEADER --}}

    <div class="editar-header">

        <h1>
            Editar usuario
        </h1>

        <p>
            Modificación de credenciales del trabajador
        </p>

    </div>


    {{-- ERRORES --}}

    @if($errors->any())

    <div class="alert alert-error">

        {{ $errors->first() }}

    </div>

    @endif


    <div class="editar-card">

        {{-- INFORMACIÓN DEL TRABAJADOR --}}

        <div class="usuario-info">

            <div>

                <strong>
                    {{ $usuario->persona->nombres ?? '' }}
                    {{ $usuario->persona->apellido_paterno ?? '' }}
                    {{ $usuario->persona->apellido_materno ?? '' }}
                </strong>

            </div>

            <div>

                <span>
                    Documento:
                    {{ $usuario->persona->numero_documento ?? '-' }}
                </span>

            </div>

        </div>


        {{-- FORMULARIO --}}

        <form
            method="POST"
            action="{{ route('usuarios.update', $usuario) }}">

            @csrf

            @method('PUT')


            {{-- USERNAME --}}

            <div class="form-group">

                <label for="username">
                    Nombre de usuario
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old(
                        'username',
                        $usuario->username
                    ) }}"
                    maxlength="50"
                    required>

            </div>

            {{-- LOCAL --}}

            <div class="form-group">

                <label for="local_id">
                    Local asignado
                </label>

                <select
                    id="local_id"
                    name="local_id"
                    required>

                    <option value="">
                        Seleccione un local
                    </option>

                    @foreach($locales as $local)

                    <option
                        value="{{ $local->id }}"
                        {{ old(
                    'local_id',
                    $usuario->locales->first()->id ?? ''
                ) == $local->id
                    ? 'selected'
                    : '' }}>

                        {{ $local->nombre }}

                    </option>

                    @endforeach

                </select>

                <div class="form-help">

                    El trabajador quedará asignado al local seleccionado.

                </div>

            </div>


            {{-- PASSWORD --}}

            <div class="form-group">

                <label for="password">
                    Nueva contraseña
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="7"
                        autocomplete="new-password"
                        placeholder="Ingrese una nueva contraseña">

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password', this)"
                        aria-label="Mostrar contraseña">

                        👁

                    </button>

                </div>


                <div class="form-help">

                    Déjalo vacío si no deseas cambiar la contraseña.

                </div>


                <div class="password-requirements">

                    <div
                        id="lengthRequirement"
                        class="password-requirement">

                        <span class="requirement-icon">
                            ✕
                        </span>

                        Más de 6 caracteres

                    </div>

                </div>

            </div>


            {{-- CONFIRMAR PASSWORD --}}

            <div class="form-group">

                <label for="password_confirmation">

                    Confirmar nueva contraseña

                </label>


                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        minlength="7"
                        autocomplete="new-password"
                        placeholder="Repita la nueva contraseña">

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password_confirmation', this)"
                        aria-label="Mostrar contraseña">

                        👁

                    </button>

                </div>


                <div
                    id="passwordMatch"
                    class="password-match">

                </div>

            </div>


            {{-- BOTONES --}}

            <div class="form-actions">

                <a
                    href="{{ route('usuarios.index') }}"
                    class="btn btn-cancelar">

                    Cancelar

                </a>


                <button
                    type="submit"
                    class="btn btn-guardar">

                    Guardar cambios

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const password =
        document.getElementById('password');

    const confirmation =
        document.getElementById('password_confirmation');

    const lengthRequirement =
        document.getElementById('lengthRequirement');

    const passwordMatch =
        document.getElementById('passwordMatch');


    function validatePassword() {

        const value = password.value;


        /*
         * En editar la contraseña puede estar vacía.
         */

        if (value === '') {

            lengthRequirement.classList.remove(
                'valid',
                'invalid'
            );

            lengthRequirement.querySelector(
                '.requirement-icon'
            ).textContent = '✕';

            password.classList.remove(
                'password-success',
                'password-error'
            );

            validateConfirmation();

            return;

        }


        if (value.length >= 7) {

            lengthRequirement.classList.remove(
                'invalid'
            );

            lengthRequirement.classList.add(
                'valid'
            );

            lengthRequirement.querySelector(
                '.requirement-icon'
            ).textContent = '✓';

            password.classList.remove(
                'password-error'
            );

            password.classList.add(
                'password-success'
            );

        } else {

            lengthRequirement.classList.remove(
                'valid'
            );

            lengthRequirement.classList.add(
                'invalid'
            );

            lengthRequirement.querySelector(
                '.requirement-icon'
            ).textContent = '✕';

            password.classList.remove(
                'password-success'
            );

            password.classList.add(
                'password-error'
            );

        }


        validateConfirmation();

    }


    function validateConfirmation() {

        const pass = password.value;
        const confirm = confirmation.value;


        /*
         * Ambos vacíos:
         * No se cambiará la contraseña.
         */

        if (pass === '' && confirm === '') {

            passwordMatch.textContent = '';

            confirmation.classList.remove(
                'password-success',
                'password-error'
            );

            return;

        }


        if (pass === confirm && pass.length >= 7) {

            passwordMatch.textContent =
                '✓ Las contraseñas coinciden.';

            passwordMatch.classList.remove(
                'invalid'
            );

            passwordMatch.classList.add(
                'valid'
            );

            confirmation.classList.remove(
                'password-error'
            );

            confirmation.classList.add(
                'password-success'
            );

        } else {

            passwordMatch.textContent =
                '✕ Las contraseñas no coinciden.';

            passwordMatch.classList.remove(
                'valid'
            );

            passwordMatch.classList.add(
                'invalid'
            );

            confirmation.classList.remove(
                'password-success'
            );

            confirmation.classList.add(
                'password-error'
            );

        }

    }


    password.addEventListener(
        'input',
        validatePassword
    );

    confirmation.addEventListener(
        'input',
        validateConfirmation
    );


    /* VALIDACIÓN ANTES DE ENVIAR */

    document.querySelector('form').addEventListener(
        'submit',
        function (event) {

            const pass = password.value;
            const confirm = confirmation.value;


            /*
             * Si ambos están vacíos:
             * permitir guardar sin cambiar password.
             */

            if (pass === '' && confirm === '') {

                return;

            }


            /*
             * Password escrito pero menor de 7.
             */

            if (pass.length < 7) {

                event.preventDefault();

                alert(
                    'La nueva contraseña debe tener más de 6 caracteres.'
                );

                password.focus();

                return;

            }


            /*
             * Password diferente a confirmación.
             */

            if (pass !== confirm) {

                event.preventDefault();

                alert(
                    'Las contraseñas no coinciden.'
                );

                confirmation.focus();

                return;

            }

        }
    );

});


/* MOSTRAR / OCULTAR PASSWORD */

function togglePassword(inputId, button) {

    const input =
        document.getElementById(inputId);


    if (input.type === 'password') {

        input.type = 'text';

        button.textContent = '🙈';

        button.setAttribute(
            'aria-label',
            'Ocultar contraseña'
        );

    } else {

        input.type = 'password';

        button.textContent = '👁';

        button.setAttribute(
            'aria-label',
            'Mostrar contraseña'
        );

    }

}

</script>

@endsection
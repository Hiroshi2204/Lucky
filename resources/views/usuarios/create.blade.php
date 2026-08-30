@extends('layouts.app')

@section('title', 'Crear trabajador - Macrotechos')

@section('styles')

<style>
    .crear-container {
        width: 100%;
        max-width: 950px;
        margin: 0 auto;
    }


    /* HEADER */

    .crear-header {
        margin-bottom: 25px;
    }

    .crear-header h1 {
        font-size: 28px;
        color: #1f2937;
        margin: 0;
    }

    .crear-header p {
        color: #6b7280;
        margin-top: 6px;
        font-size: 14px;
    }


    /* CARD */

    .crear-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }


    /* SECCIONES */

    .form-section {
        margin-bottom: 30px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 17px;
        font-weight: 700;
        color: #1f2937;
        padding-bottom: 12px;
        margin-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .section-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
    }


    /* GRID */

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }


    /* LABEL */

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }

    .required {
        color: #dc2626;
    }


    /* INPUT */

    .form-control {
        width: 100%;
        height: 42px;
        padding: 0 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        color: #1f2937;
        font-size: 14px;
        outline: none;
        transition: .2s;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }


    /* AYUDA */

    .form-help {
        margin-top: 5px;
        color: #9ca3af;
        font-size: 12px;
    }


    /* ALERTAS */

    .form-errors {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 8px;
        padding: 14px 18px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .form-errors ul {
        margin: 0;
        padding-left: 20px;
    }

    .form-errors li {
        margin: 3px 0;
    }


    /* INFORMACIÓN */

    .info-box {
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #1e40af;
        padding: 13px 15px;
        border-radius: 8px;
        font-size: 13px;
        margin-top: 20px;
    }


    /* BOTONES */

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        border-top: 1px solid #e5e7eb;
        padding-top: 25px;
        margin-top: 30px;
    }

    .btn {
        height: 42px;
        padding: 0 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
    }

    .btn-primary {
        border: 0;
        background: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }


    /* RESPONSIVE */

    @media(max-width: 700px) {

        .crear-card {
            padding: 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .crear-header h1 {
            font-size: 24px;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn {
            width: 100%;
        }

    }

    /* =====================================================
   CONTRASEÑA
===================================================== */

    .password-wrapper {
        position: relative;
    }

    .password-wrapper .form-control {
        padding-right: 45px;
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
        margin-top: 10px;
        padding: 10px 12px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .password-requirement {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        color: #6b7280;
        margin: 4px 0;
    }

    .password-requirement.valid {
        color: #15803d;
    }

    .password-requirement.invalid {
        color: #dc2626;
    }

    .requirement-icon {
        font-weight: bold;
        width: 14px;
    }


    /* CONFIRMACIÓN */

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


    /* INPUT ERROR */

    .password-error {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .08) !important;
    }

    .password-success {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, .08) !important;
    }


    /* BOTÓN DESHABILITADO */

    .btn-primary:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    @media(max-width: 700px) {

        .password-requirements {
            font-size: 11px;
        }

    }
</style>

@endsection


@section('content')

<div class="crear-container">


    {{-- HEADER --}}

    <div class="crear-header">

        <h1>
            Crear trabajador
        </h1>

        <p>
            Registra un nuevo trabajador y asigna el local donde podrá operar.
        </p>

    </div>


    {{-- ERRORES --}}

    @if($errors->any())

    <div class="form-errors">

        <strong>
            No se pudo completar el registro:
        </strong>

        <ul>

            @foreach($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

            @endforeach

        </ul>

    </div>

    @endif


    <div class="crear-card">

        <form
            method="POST"
            action="{{ route('usuarios.store') }}">

            @csrf


            {{-- =====================================================
                 DATOS PERSONALES
            ====================================================== --}}

            <div class="form-section">

                <div class="section-title">

                    <span class="section-number">
                        1
                    </span>

                    Datos personales

                </div>


                <div class="form-grid">


                    {{-- DOCUMENTO --}}

                    <div class="form-group">

                        <label class="form-label">

                            Número de documento
                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            name="numero_documento"
                            class="form-control"
                            value="{{ old('numero_documento') }}"
                            placeholder="Ingrese el documento"
                            required>

                    </div>


                    {{-- NOMBRES --}}

                    <div class="form-group">

                        <label class="form-label">

                            Nombres
                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            name="nombres"
                            class="form-control"
                            value="{{ old('nombres') }}"
                            placeholder="Ingrese los nombres"
                            required>

                    </div>


                    {{-- APELLIDO PATERNO --}}

                    <div class="form-group">

                        <label class="form-label">

                            Apellido paterno
                            <span class="required">*</span>

                        </label>

                        <input
                            type="text"
                            name="apellido_paterno"
                            class="form-control"
                            value="{{ old('apellido_paterno') }}"
                            placeholder="Ingrese el apellido paterno"
                            required>

                    </div>


                    {{-- APELLIDO MATERNO --}}

                    <div class="form-group">

                        <label class="form-label">

                            Apellido materno

                        </label>

                        <input
                            type="text"
                            name="apellido_materno"
                            class="form-control"
                            value="{{ old('apellido_materno') }}"
                            placeholder="Ingrese el apellido materno">

                    </div>


                    {{-- CELULAR --}}

                    <div class="form-group">

                        <label class="form-label">
                            Celular
                        </label>

                        <input
                            type="text"
                            name="celular"
                            class="form-control"
                            value="{{ old('celular') }}"
                            placeholder="Ingrese el celular">

                    </div>


                    {{-- CORREO --}}

                    <div class="form-group">

                        <label class="form-label">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            name="correo"
                            class="form-control"
                            value="{{ old('correo') }}"
                            placeholder="ejemplo@correo.com">

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ACCESO
            ====================================================== --}}

            <div class="form-section">

                <div class="section-title">

                    <span class="section-number">
                        2
                    </span>

                    Acceso al sistema

                </div>


                <div class="form-grid">


                    {{-- USUARIO --}}

                    <div class="form-group full">

                        <label class="form-label">
                            Usuario
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="username"
                            required
                            maxlength="50"
                            placeholder="Ej. lgaray">

                        <span class="form-help">
                            Este será el usuario que utilizará el trabajador para iniciar sesión.
                        </span>

                    </div>


                    {{-- PASSWORD --}}

                    <div class="form-group">

                        <label class="form-label">

                            Contraseña
                            <span class="required">*</span>

                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Ingrese una contraseña"
                                minlength="7"
                                required>

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword('password', this)"
                                aria-label="Mostrar contraseña">

                                👁

                            </button>

                        </div>


                        {{-- REQUISITOS --}}

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

                        <label class="form-label">

                            Confirmar contraseña
                            <span class="required">*</span>

                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Repita la contraseña"
                                minlength="7"
                                required>

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

                </div>

            </div>


            {{-- =====================================================
                 LOCAL
            ====================================================== --}}

            <div class="form-section">

                <div class="section-title">

                    <span class="section-number">
                        3
                    </span>

                    Asignación de local

                </div>


                <div class="form-grid">

                    <div class="form-group full">

                        <label class="form-label">

                            Local
                            <span class="required">*</span>

                        </label>


                        <select
                            name="local_id"
                            class="form-control"
                            required>

                            <option value="">
                                Seleccione el local donde trabajará
                            </option>


                            @foreach($locales as $local)

                            <option
                                value="{{ $local->id }}"
                                {{ old('local_id') == $local->id
                                        ? 'selected'
                                        : '' }}>

                                {{ $local->nombre }}

                            </option>

                            @endforeach

                        </select>


                        <span class="form-help">

                            El trabajador solamente podrá operar en el local asignado.

                        </span>

                    </div>

                </div>


                <div class="info-box">

                    <strong>Importante:</strong>

                    El trabajador será registrado con el rol
                    <strong>Trabajador</strong>
                    y podrá acceder únicamente al local seleccionado.

                </div>

            </div>


            {{-- =====================================================
                 BOTONES
            ====================================================== --}}

            <div class="form-actions">

                <a
                    href="{{ route('usuarios.index') }}"
                    class="btn btn-secondary">

                    Cancelar

                </a>


                <button
                    type="submit"
                    class="btn btn-primary">

                    Crear trabajador

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');

    const lengthRequirement =
        document.getElementById('lengthRequirement');

    const passwordMatch =
        document.getElementById('passwordMatch');


    function validatePassword() {

        const value = password.value;

        if (value.length >= 7) {

            lengthRequirement.classList.remove('invalid');
            lengthRequirement.classList.add('valid');

            lengthRequirement.querySelector('.requirement-icon')
                .textContent = '✓';

            password.classList.remove('password-error');

            password.classList.add('password-success');

        } else {

            lengthRequirement.classList.remove('valid');
            lengthRequirement.classList.add('invalid');

            lengthRequirement.querySelector('.requirement-icon')
                .textContent = '✕';

            password.classList.remove('password-success');

            if (value.length > 0) {
                password.classList.add('password-error');
            } else {
                password.classList.remove('password-error');
            }

        }

        validateConfirmation();

    }


    function validateConfirmation() {

        const pass = password.value;
        const confirm = confirmation.value;

        if (confirm === '') {

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

            passwordMatch.classList.remove('invalid');
            passwordMatch.classList.add('valid');

            confirmation.classList.remove('password-error');
            confirmation.classList.add('password-success');

        } else {

            passwordMatch.textContent =
                '✕ Las contraseñas no coinciden.';

            passwordMatch.classList.remove('valid');
            passwordMatch.classList.add('invalid');

            confirmation.classList.remove('password-success');
            confirmation.classList.add('password-error');

        }

    }


    password.addEventListener('input', validatePassword);

    confirmation.addEventListener(
        'input',
        validateConfirmation
    );


    /* VALIDACIÓN AL ENVIAR */

    document.querySelector('form').addEventListener('submit', function (event) {

        const pass = password.value;
        const confirm = confirmation.value;


        if (pass.length < 7) {

            event.preventDefault();

            alert('La contraseña debe tener más de 6 caracteres.');

            password.focus();

            return;

        }


        if (pass !== confirm) {

            event.preventDefault();

            alert('Las contraseñas no coinciden.');

            confirmation.focus();

            return;

        }

    });

});


/* MOSTRAR / OCULTAR PASSWORD */

function togglePassword(inputId, button) {

    const input = document.getElementById(inputId);

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
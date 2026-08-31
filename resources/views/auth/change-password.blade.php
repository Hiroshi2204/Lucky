@extends('layouts.app')

@section('title', 'Cambiar contraseña - Lucky')

@section('styles')
<style>
    .password-page {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
    }

    .password-card {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 14px;
        padding: 32px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
    }

    .password-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        margin: 0 auto 18px;
    }

    .password-card h1 {
        margin: 0;
        text-align: center;
        color: #1f2937;
        font-size: 24px;
    }

    .password-card .description {
        margin: 10px 0 25px;
        text-align: center;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.5;
    }

    .warning-box {
        background: #fff7ed;
        border: 1px solid #fed7aa;
        color: #9a3412;
        border-radius: 9px;
        padding: 13px 15px;
        margin-bottom: 22px;
        font-size: 13px;
        line-height: 1.45;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }

    .required {
        color: #dc2626;
    }

    .password-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        height: 44px;
        padding: 0 45px 0 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        box-sizing: border-box;
        outline: none;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        cursor: pointer;
        font-size: 16px;
    }

    .requirements {
        margin-top: 7px;
        color: #6b7280;
        font-size: 12px;
    }

    .errors {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .errors ul {
        margin: 0;
        padding-left: 20px;
    }

    .btn-submit {
        width: 100%;
        height: 44px;
        border: 0;
        border-radius: 8px;
        background: #2563eb;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 5px;
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }

    .logout-form {
        text-align: center;
        margin-top: 15px;
    }

    .logout-form button {
        border: 0;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        font-size: 13px;
    }

    .logout-form button:hover {
        color: #dc2626;
    }
</style>
@endsection

@section('content')
<div class="password-page">

    <div class="password-card">

        <div class="password-icon">
            🔐
        </div>

        <h1>
            Cambiar contraseña
        </h1>

        <p class="description">
            Por seguridad, debe establecer una contraseña personal
            antes de continuar utilizando Lucky.
        </p>

        <div class="warning-box">
            <strong>Contraseña temporal.</strong><br>
            La contraseña con la que ingresó fue asignada por el administrador
            y debe ser reemplazada por una contraseña personal.
        </div>

        @if($errors->any())
        <div class="errors">
            <strong>No se pudo cambiar la contraseña:</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div class="form-group">

                <label class="form-label">
                    Nueva contraseña
                    <span class="required">*</span>
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        minlength="7"
                        required
                        autocomplete="new-password">

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password', this)">
                        👁
                    </button>

                </div>

                <div class="requirements">
                    Mínimo 7 caracteres.
                </div>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Confirmar nueva contraseña
                    <span class="required">*</span>
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        minlength="7"
                        required
                        autocomplete="new-password">

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password_confirmation', this)">
                        👁
                    </button>

                </div>

            </div>

            <button type="submit" class="btn-submit">
                Guardar nueva contraseña
            </button>

        </form>

        <div class="logout-form">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    Cerrar sesión
                </button>
            </form>
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    function togglePassword(inputId, button) {

        const input =
            document.getElementById(inputId);

        if (input.type === 'password') {

            input.type = 'text';

            button.textContent = '🙈';

        } else {

            input.type = 'password';

            button.textContent = '👁';
        }
    }
</script>
@endsection
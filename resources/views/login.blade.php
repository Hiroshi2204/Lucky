<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Macrotechos - Iniciar sesión</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7fb;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
        }

        /* =========================
           PANEL IZQUIERDO
        ========================= */

        .login-brand {
            width: 55%;
            min-height: 100vh;
            position: relative;
            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    rgba(15, 23, 42, 0.98),
                    rgba(30, 64, 175, 0.95)
                );

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .login-brand::before {
            content: "";
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            top: -180px;
            right: -150px;
        }

        .login-brand::after {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            bottom: -150px;
            left: -120px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            max-width: 520px;
        }

        .brand-logo {
            width: 76px;
            height: 76px;
            border-radius: 18px;

            background: rgba(255, 255, 255, 0.12);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 34px;
            font-weight: 700;

            margin-bottom: 30px;

            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .brand-title {
            font-size: 52px;
            font-weight: 700;
            letter-spacing: -2px;
            margin-bottom: 10px;
        }

        .brand-subtitle {
            font-size: 20px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.78);
            margin-bottom: 35px;
        }

        .brand-description {
            font-size: 16px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.68);
            max-width: 460px;
        }

        .brand-features {
            margin-top: 40px;
        }

        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            color: rgba(255, 255, 255, 0.85);
            font-size: 15px;
        }

        .feature-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;

            background: rgba(255, 255, 255, 0.10);

            display: flex;
            align-items: center;
            justify-content: center;

            margin-right: 12px;
            font-size: 15px;
        }

        /* =========================
           PANEL DERECHO
        ========================= */

        .login-panel {
            width: 45%;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px;
            background: #ffffff;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            margin-bottom: 35px;
        }

        .login-header h1 {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .login-header p {
            margin: 0;
            color: #6b7280;
            font-size: 15px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
        }

        .form-control-custom {
            width: 100%;
            height: 52px;

            border: 1px solid #d9dee7;
            border-radius: 10px;

            padding: 0 16px;

            font-size: 15px;
            color: #111827;

            background: #ffffff;

            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            outline: none;

            border-color: #2563eb;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        .form-control-custom::placeholder {
            color: #9ca3af;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control-custom {
            padding-right: 50px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;

            transform: translateY(-50%);

            border: none;
            background: transparent;

            color: #6b7280;

            cursor: pointer;

            font-size: 16px;
        }

        .toggle-password:hover {
            color: #2563eb;
        }

        .login-button {
            width: 100%;
            height: 52px;

            border: none;
            border-radius: 10px;

            background: #2563eb;
            color: white;

            font-size: 15px;
            font-weight: 600;

            transition: all 0.2s ease;

            margin-top: 8px;
        }

        .login-button:hover {
            background: #1d4ed8;

            transform: translateY(-1px);

            box-shadow:
                0 8px 18px rgba(37, 99, 235, 0.20);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .security-message {
            margin-top: 25px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            color: #9ca3af;
            font-size: 13px;
        }

        .footer-text {
            margin-top: 45px;

            text-align: center;

            font-size: 12px;
            color: #9ca3af;
        }

        /* =========================
           ALERTAS
        ========================= */

        .alert-custom {
            border: none;
            border-radius: 10px;

            font-size: 14px;

            padding: 13px 15px;
            margin-bottom: 20px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .login-brand {
                display: none;
            }

            .login-panel {
                width: 100%;
                padding: 25px;
            }

            .login-box {
                max-width: 420px;
            }
        }

        @media (max-width: 480px) {

            .login-panel {
                padding: 20px;
            }

            .login-header h1 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <!-- =========================
         PANEL DE PRESENTACIÓN
    ========================== -->

    <section class="login-brand">

        <div class="brand-content">

            <div class="brand-logo">
                ML
            </div>

            <div class="brand-title">
                Macrotechos Lopez S.A.C
            </div>

            <div class="brand-subtitle">
                Sistema de Almacén y Ventas
            </div>

            <div class="brand-description">
                Plataforma integral para la gestión de inventario,
                movimientos de stock y ventas de manera segura,
                organizada y eficiente.
            </div>

            <div class="brand-features">

                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    Control de inventario
                </div>

                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    Gestión de ventas y pagos
                </div>

                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    Información segura y centralizada
                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         PANEL DE LOGIN
    ========================== -->

    <section class="login-panel">

        <div class="login-box">

            <div class="login-header">

                <h1>
                    Bienvenido
                </h1>

                <p>
                    Ingresa tus credenciales para continuar.
                </p>

            </div>


            <!-- MENSAJE DE ÉXITO -->

            @if(session('success'))

                <div class="alert alert-success alert-custom">

                    {{ session('success') }}

                </div>

            @endif


            <!-- ERRORES -->

            @if($errors->any())

                <div class="alert alert-danger alert-custom">

                    {{ $errors->first() }}

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('login.authenticate') }}"
            >

                @csrf


                <!-- USUARIO -->

                <div class="mb-4">

                    <label
                        for="username"
                        class="form-label"
                    >
                        Usuario
                    </label>

                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="form-control-custom"
                        value="{{ old('username') }}"
                        placeholder="Ingresa tu usuario"
                        required
                        autofocus
                        autocomplete="username"
                    >

                </div>


                <!-- CONTRASEÑA -->

                <div class="mb-4">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Contraseña
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control-custom"
                            placeholder="Ingresa tu contraseña"
                            required
                            autocomplete="current-password"
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Mostrar contraseña"
                        >
                            👁
                        </button>

                    </div>

                </div>


                <!-- BOTÓN -->

                <button
                    type="submit"
                    class="login-button"
                >
                    Iniciar sesión
                </button>

            </form>


            <div class="security-message">

                <span>🔒</span>

                Acceso protegido y seguro

            </div>


            <div class="footer-text">

                © {{ date('Y') }} Macrotechos Lopez S.A.C · Sistema desarrollado por Hiroshi NG

            </div>

        </div>

    </section>

</div>


<script>

    const togglePassword =
        document.getElementById('togglePassword');

    const password =
        document.getElementById('password');


    togglePassword.addEventListener('click', function () {

        const type =
            password.getAttribute('type') === 'password'
                ? 'text'
                : 'password';

        password.setAttribute('type', type);

        this.textContent =
            type === 'password'
                ? '👁'
                : '🙈';

    });

</script>

</body>

</html>


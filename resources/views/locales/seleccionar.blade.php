<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Macrotechos - Seleccionar local</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background:
                linear-gradient(135deg,
                    #f8fafc 0%,
                    #eef4ff 50%,
                    #f8fafc 100%);

            color: #1f2937;
        }


        /* CONTENEDOR */

        .local-page {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 25px;
        }


        /* TARJETA */

        .local-card {
            width: 100%;
            max-width: 470px;

            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 18px;

            box-shadow:
                0 20px 45px rgba(15, 23, 42, .08),
                0 4px 12px rgba(15, 23, 42, .04);

            overflow: hidden;
        }


        /* CABECERA */

        .local-card-header {
            padding: 34px 35px 25px;

            text-align: center;

            border-bottom: 1px solid #f1f5f9;
        }


        /* LOGO */

        .brand-icon {
            width: 64px;
            height: 64px;

            margin: 0 auto 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 16px;

            background: linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);

            color: white;

            font-size: 28px;
            font-weight: 800;

            box-shadow:
                0 8px 20px rgba(37, 99, 235, .25);
        }


        .brand-name {
            margin: 0;

            font-size: 27px;
            font-weight: 750;

            letter-spacing: -.5px;

            color: #111827;
        }


        .brand-subtitle {
            margin: 8px 0 0;

            color: #64748b;

            font-size: 14px;
            line-height: 1.5;
        }


        /* CONTENIDO */

        .local-card-body {
            padding: 30px 35px 35px;
        }


        /* INDICADOR */

        .step-container {
            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 25px;
        }


        .step-number {
            width: 30px;
            height: 30px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #eff6ff;

            color: #2563eb;

            font-size: 13px;
            font-weight: 700;
        }


        .step-text {
            font-size: 13px;
            color: #64748b;
        }


        .step-text strong {
            display: block;

            color: #374151;

            font-size: 14px;
        }


        /* ALERTA */

        .alert-custom {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            padding: 13px 14px;

            margin-bottom: 22px;

            border-radius: 10px;

            background: #fef2f2;

            border: 1px solid #fecaca;

            color: #991b1b;

            font-size: 13px;
        }


        .alert-icon {
            font-weight: 700;
            font-size: 15px;
        }


        /* LABEL */

        .local-label {
            display: block;

            margin-bottom: 9px;

            color: #374151;

            font-size: 14px;
            font-weight: 650;
        }


        /* SELECT */

        .local-select-wrapper {
            position: relative;
        }


        .local-select {
            width: 100%;

            min-height: 52px;

            padding: 12px 42px 12px 15px;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            background-color: #ffffff;

            color: #374151;

            font-size: 14px;

            outline: none;

            appearance: none;

            cursor: pointer;

            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }


        .local-select:hover {
            border-color: #9ca3af;
        }


        .local-select:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, .10);
        }


        .select-arrow {
            position: absolute;

            right: 16px;
            top: 50%;

            transform: translateY(-50%);

            pointer-events: none;

            color: #64748b;

            font-size: 16px;
        }


        /* AYUDA */

        .local-help {
            margin-top: 9px;

            color: #94a3b8;

            font-size: 12px;
        }


        /* BOTÓN */

        .btn-continuar {
            width: 100%;

            min-height: 52px;

            margin-top: 25px;

            border: none;

            border-radius: 10px;

            background: linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);

            color: white;

            font-size: 14px;
            font-weight: 650;

            cursor: pointer;

            box-shadow:
                0 7px 18px rgba(37, 99, 235, .20);

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }


        .btn-continuar:hover {
            transform: translateY(-1px);

            box-shadow:
                0 10px 22px rgba(37, 99, 235, .27);

            background: linear-gradient(135deg,
                    #1d4ed8,
                    #1e40af);
        }


        .btn-continuar:active {
            transform: translateY(0);
        }


        .btn-content {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 9px;
        }


        .btn-arrow {
            font-size: 18px;

            line-height: 1;
        }


        /* FOOTER */

        .local-footer {
            padding: 18px 25px;

            text-align: center;

            border-top: 1px solid #f1f5f9;

            background: #fafafa;

            color: #94a3b8;

            font-size: 11px;
        }


        /* RESPONSIVE */

        @media (max-width: 576px) {

            .local-page {
                padding: 15px;
            }

            .local-card-header {
                padding: 28px 23px 22px;
            }

            .local-card-body {
                padding: 25px 23px 28px;
            }

            .brand-icon {
                width: 56px;
                height: 56px;

                font-size: 24px;
            }

            .brand-name {
                font-size: 24px;
            }

        }
    </style>

</head>


<body>


    <div class="local-page">


        <div class="local-card">


            {{-- CABECERA --}}

            <div class="local-card-header">

                <div class="brand-icon">
                    ML
                </div>

                <h1 class="brand-name">
                    Macrotechos Lopez
                </h1>

                <p class="brand-subtitle">
                    Selecciona el local donde realizarás
                    tus actividades.
                </p>

            </div>


            {{-- CONTENIDO --}}

            <div class="local-card-body">


                {{-- PASO --}}

                <div class="step-container">

                    <div class="step-number">
                        1
                    </div>

                    <div class="step-text">

                        <strong>
                            Selección de local
                        </strong>

                        Elige el establecimiento correspondiente.

                    </div>

                </div>


                {{-- ERRORES --}}

                @if($errors->any())

                <div class="alert-custom">

                    <span class="alert-icon">
                        !
                    </span>

                    <span>
                        {{ $errors->first() }}
                    </span>

                </div>

                @endif


                {{-- FORMULARIO --}}

                <form
                    method="POST"
                    action="{{ route('local.guardar') }}">

                    @csrf


                    {{-- LOCAL --}}

                    <div>

                        <label
                            for="local_id"
                            class="local-label">
                            Local
                        </label>


                        <div class="local-select-wrapper">

                            <select
                                name="local_id"
                                id="local_id"
                                class="local-select"
                                required>

                                <option
                                    value=""
                                    selected
                                    disabled>
                                    Seleccione un local
                                </option>


                                @foreach($locales as $local)

                                <option
                                    value="{{ $local->id }}">

                                    {{ $local->nombre }}

                                    @if($local->codigo)

                                    — {{ $local->codigo }}

                                    @endif

                                </option>

                                @endforeach

                            </select>


                            <span class="select-arrow">
                                ▼
                            </span>

                        </div>


                        <div class="local-help">

                            El local seleccionado determinará
                            dónde se registrarán tus operaciones.

                        </div>

                    </div>


                    {{-- BOTÓN --}}

                    <button
                        type="submit"
                        class="btn-continuar">

                        <span class="btn-content">

                            Continuar

                            <span class="btn-arrow">
                                →
                            </span>

                        </span>

                    </button>

                </form>

            </div>


            {{-- FOOTER --}}

            <div class="local-footer">

                Sistema de gestión · Macrotechos

            </div>


        </div>

    </div>


</body>

</html>
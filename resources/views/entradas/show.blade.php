<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Detalle de Entrada</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 25px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
        }

        .header p {
            color: #6b7280;
            margin-top: 5px;
        }

        .panel {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,.06);
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .item {
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .label {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .value {
            font-size: 17px;
            font-weight: bold;
        }

        .stock {
            margin-top: 25px;
            padding: 20px;
            background: #dcfce7;
            color: #166534;
            border-radius: 10px;
            text-align: center;
        }

        .stock strong {
            display: block;
            font-size: 30px;
            margin-top: 5px;
        }

        .buttons {
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        @media(max-width:600px) {

            .container {
                padding: 15px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <h1>Detalle de entrada</h1>

        <p>
            Entrada #{{ $entrada->id }}
        </p>

    </div>


    <div class="panel">


        <div class="grid">


            <div class="item">

                <div class="label">
                    Código
                </div>

                <div class="value">
                    {{ $entrada->producto->codigo }}
                </div>

            </div>


            <div class="item">

                <div class="label">
                    Descripción
                </div>

                <div class="value">
                    {{ $entrada->producto->descripcion }}
                </div>

            </div>


            <div class="item">

                <div class="label">
                    Espesor
                </div>

                <div class="value">

                    {{ number_format(
                        $entrada->producto->espesor,
                        3
                    ) }}

                </div>

            </div>


            <div class="item">

                <div class="label">
                    Cantidad ingresada
                </div>

                <div class="value">

                    +
                    {{ number_format(
                        $entrada->cantidad,
                        3
                    ) }}

                </div>

            </div>


            <div class="item">

                <div class="label">
                    Fecha
                </div>

                <div class="value">

                    {{ $entrada->fecha->format(
                        'd/m/Y H:i'
                    ) }}

                </div>

            </div>


            <div class="item">

                <div class="label">
                    Observación
                </div>

                <div class="value">

                    {{ $entrada->observacion ?? '-' }}

                </div>

            </div>

        </div>


        <div class="stock">

            Stock actual del producto

            <strong>

                {{ number_format(
                    $stock,
                    3
                ) }}

            </strong>

        </div>


        <div class="buttons">

            <a
                href="{{ route('entradas.index') }}"
                class="btn btn-secondary"
            >
                ← Volver a entradas
            </a>

        </div>

    </div>

</div>

</body>

</html>
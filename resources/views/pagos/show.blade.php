<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Pago #{{ $pago->id }}</title>

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
            max-width: 700px;
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
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        }

        .detalle {
            display: grid;
            grid-template-columns: 180px 1fr;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 0;
        }

        .detalle:last-child {
            border-bottom: none;
        }

        .label {
            color: #6b7280;
            font-weight: bold;
        }

        .monto {
            font-size: 28px;
            color: #15803d;
            font-weight: bold;
        }

        .acciones {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 11px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        @media(max-width:600px) {

            .container {
                padding: 15px;
            }

            .detalle {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .acciones {
                flex-direction: column;
            }

            .btn {
                text-align: center;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">

            <h1>
                Pago #{{ $pago->id }}
            </h1>

            <p>
                Detalle del pago registrado
            </p>

        </div>


        <div class="panel">

            <div class="detalle">

                <div class="label">
                    Venta
                </div>

                <div>
                    #{{ $pago->venta_id }}
                </div>

            </div>


            <div class="detalle">

                <div class="label">
                    Fecha
                </div>

                <div>
                    {{ $pago->fecha->format('d/m/Y H:i:s') }}
                </div>

            </div>


            <div class="detalle">

                <div class="label">
                    Monto
                </div>

                <div class="monto">

                    S/
                    {{ number_format($pago->monto, 2) }}

                </div>

            </div>


            <div class="detalle">

                <div class="label">
                    Medio de pago
                </div>

                <div>

                    {{ $pago->medio_pago }}

                    @if($pago->medio_pago === 'OTRO')

                    <br>

                    {{ $pago->medio_pago_otro }}

                    @endif

                </div>

            </div>


            <div class="detalle">

                <div class="label">
                    Observación
                </div>

                <div>
                    {{ $pago->observacion ?: '-' }}
                </div>

            </div>


            <div class="acciones">

                <a
                    href="{{ route('pagos.index', $pago->venta) }}"
                    class="btn btn-primary">
                    ← Historial de pagos
                </a>

                <a
                    href="{{ route('ventas.show', $pago->venta) }}"
                    class="btn btn-secondary">
                    Ver venta
                </a>

            </div>

        </div>

    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Pagos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 19px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .fecha {
            text-align: right;
            font-size: 8px;
            margin-bottom: 8px;
        }

        .filtros {
            background: #f3f4f6;
            padding: 8px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1f2937;
            color: white;
            padding: 7px;
            border: 1px solid #333;
        }

        td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .total {
            margin-top: 15px;
            text-align: right;
            font-size: 11px;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #777;
        }
    </style>

</head>

<body>

    <div class="header">

        <h1>
            REPORTE DE PAGOS
        </h1>

        <p>
            Historial de pagos recibidos
        </p>

    </div>


    <div class="fecha">

        Generado:
        {{ now()->format('d/m/Y H:i:s') }}

    </div>


    <div class="filtros">

        <strong>Medio:</strong>
        {{ $filtros['medio_pago'] }}

        &nbsp;&nbsp;

        <strong>Desde:</strong>
        {{ $filtros['fecha_inicio'] }}

        &nbsp;&nbsp;

        <strong>Hasta:</strong>
        {{ $filtros['fecha_fin'] }}

    </div>


    <table>

        <thead>

            <tr>

                <th>N.º Pago</th>

                <th>Venta</th>

                <th>Fecha</th>

                <th>Medio de pago</th>

                <th>Monto</th>

                <th>Observación</th>

            </tr>

        </thead>

        <tbody>

            @forelse($pagos as $pago)

            <tr>

                <td class="center">
                    #{{ $pago->id }}
                </td>

                <td class="center">

                    #{{ $pago->venta_id }}

                </td>

                <td>

                    {{ $pago->fecha?->format(
                            'd/m/Y H:i'
                        ) }}

                </td>

                <td class="center">

                    {{ $pago->medio_pago }}

                    @if($pago->medio_pago_otro)

                    <br>

                    <small>
                        {{ $pago->medio_pago_otro }}
                    </small>

                    @endif

                </td>

                <td class="right">

                    <strong>

                        S/
                        {{ number_format(
                                $pago->monto,
                                2
                            ) }}

                    </strong>

                </td>

                <td>

                    {{ $pago->observacion ?: '-' }}

                </td>

            </tr>

            @empty

            <tr>

                <td
                    colspan="6"
                    class="center">

                    No existen pagos registrados.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>


    <div class="total">

        Total de pagos:

        {{ $pagos->count() }}

        <br>

        Total recaudado:

        S/
        {{ number_format(
            $pagos->sum('monto'),
            2
        ) }}

    </div>


    <div class="footer">

        Sistema de Gestión de Inventario -
        Reporte generado automáticamente

    </div>

</body>

</html>
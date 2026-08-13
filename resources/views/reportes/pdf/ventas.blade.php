<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Ventas</title>

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

        .cancelado {
            color: #166534;
            font-weight: bold;
        }

        .parcial {
            color: #92400e;
            font-weight: bold;
        }

        .pendiente {
            color: #991b1b;
            font-weight: bold;
        }

        .anulada {
            color: #991b1b;
            font-weight: bold;
        }

        .resumen {
            margin-top: 15px;
            text-align: right;
            font-size: 10px;
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
            REPORTE DE VENTAS
        </h1>

        <p>
            Gestión de ventas
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

        <strong>Estado pago:</strong>
        {{ $filtros['estado_pago'] }}

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

                <th>N.º</th>

                <th>Fecha</th>

                <th>Total</th>

                <th>Pagado</th>

                <th>Saldo</th>

                <th>Medio</th>

                <th>Estado pago</th>

                <th>Estado venta</th>

            </tr>

        </thead>

        <tbody>

            @forelse($ventas as $venta)

            <tr>

                <td class="center">
                    #{{ $venta->id }}
                </td>

                <td>
                    {{ $venta->fecha?->format('d/m/Y H:i') }}
                </td>

                <td class="right">

                    S/
                    {{ number_format(
                            $venta->total,
                            2
                        ) }}

                </td>

                <td class="right">

                    S/
                    {{ number_format(
                            $venta->monto_pagado,
                            2
                        ) }}

                </td>

                <td class="right">

                    S/
                    {{ number_format(
                            $venta->saldo_pendiente,
                            2
                        ) }}

                </td>

                <td class="center">

                    {{ $venta->medio_pago }}

                </td>

                <td class="center">

                    @if($venta->estado_pago === 'CANCELADO')

                    <span class="cancelado">
                        CANCELADO
                    </span>

                    @elseif($venta->estado_pago === 'PARCIAL')

                    <span class="parcial">
                        PARCIAL
                    </span>

                    @else

                    <span class="pendiente">
                        {{ $venta->estado_pago }}
                    </span>

                    @endif

                </td>

                <td class="center">

                    @if($venta->estado === 'ACTIVA')

                    ACTIVA

                    @else

                    <span class="anulada">
                        ANULADA
                    </span>

                    @endif

                </td>

            </tr>

            @empty

            <tr>

                <td
                    colspan="8"
                    class="center">

                    No existen ventas.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>


    <div class="resumen">

        <strong>
            Total de ventas:
        </strong>

        {{ $ventas->count() }}

        <br>

        <strong>
            Total vendido:
        </strong>

        S/
        {{ number_format(
            $ventas->sum('total'),
            2
        ) }}

        <br>

        <strong>
            Total cobrado:
        </strong>

        S/
        {{ number_format(
            $ventas->sum('monto_pagado'),
            2
        ) }}

        <br>

        <strong>
            Total pendiente:
        </strong>

        S/
        {{ number_format(
            $ventas->sum('saldo_pendiente'),
            2
        ) }}

    </div>


    <div class="footer">

        Sistema de Gestión de Inventario -
        Reporte generado automáticamente

    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Movimientos</title>

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

        .filtros {
            background: #f3f4f6;
            padding: 8px;
            margin-bottom: 15px;
        }

        .filtros strong {
            margin-right: 5px;
        }

        .fecha {
            text-align: right;
            font-size: 8px;
            margin-bottom: 8px;
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

        .entrada {
            color: #166534;
            font-weight: bold;
        }

        .salida {
            color: #991b1b;
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
            REPORTE DE MOVIMIENTOS
        </h1>

        <p>
            Entradas y salidas de inventario
        </p>

    </div>


    <div class="fecha">

        Generado:
        {{ now()->format('d/m/Y H:i:s') }}

    </div>


    <div class="filtros">

        <strong>Producto:</strong>
        {{ $filtros['producto'] ?? 'Todos' }}

        &nbsp;&nbsp;

        <strong>Tipo:</strong>
        {{ $filtros['tipo'] ?? 'Todos' }}

        &nbsp;&nbsp;

        <strong>Desde:</strong>
        {{ $filtros['fecha_inicio'] ?? 'Todas' }}

        &nbsp;&nbsp;

        <strong>Hasta:</strong>
        {{ $filtros['fecha_fin'] ?? 'Todas' }}

    </div>


    <table>

        <thead>

            <tr>

                <th>Fecha</th>

                <th>Código</th>

                <th>Descripción</th>

                <th>Tipo</th>

                <th>Cantidad</th>

                <th>Observación</th>

            </tr>

        </thead>

        <tbody>

            @forelse($movimientos as $movimiento)

            <tr>

                <td>
                    {{ $movimiento->fecha?->format('d/m/Y H:i') }}
                </td>

                <td>
                    {{ $movimiento->producto->codigo ?? '-' }}
                </td>

                <td>
                    {{ $movimiento->producto->descripcion ?? '-' }}
                </td>

                <td class="center">

                    @if($movimiento->tipo === 'ENTRADA')

                    <span class="entrada">
                        ENTRADA
                    </span>

                    @else

                    <span class="salida">
                        SALIDA
                    </span>

                    @endif

                </td>

                <td class="right">

                    {{ number_format(
                            $movimiento->cantidad,
                            3
                        ) }}

                </td>

                <td>
                    {{ $movimiento->observacion ?? '-' }}
                </td>

            </tr>

            @empty

            <tr>

                <td
                    colspan="6"
                    class="center">

                    No existen movimientos.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        Sistema de Gestión de Inventario -
        Reporte generado automáticamente

    </div>

</body>

</html>
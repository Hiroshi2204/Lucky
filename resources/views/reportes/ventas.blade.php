<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Reporte de Ventas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .container {
            max-width: 1400px;
            margin: auto;
            padding: 25px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header p {
            color: #6b7280;
            margin-top: 5px;
        }

        .acciones {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
        }

        .primary {
            background: #2563eb;
        }

        .danger {
            background: #dc2626;
        }

        .success {
            background: #16a34a;
        }

        .panel {
            background: white;
            padding: 20px;
            border-radius: 12px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            padding: 12px;
            text-align: left;
            color: #6b7280;
        }

        td {
            padding: 12px;
            border-top: 1px solid #eee;
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
            color: #dc2626;
            font-weight: bold;
        }

        .anulada {
            color: #991b1b;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">

            <div>

                <h1>
                    Reporte de Ventas
                </h1>

                <p>
                    Historial de ventas realizadas
                </p>

            </div>

            <div class="acciones">

                <a
                    href="{{ route('reportes.index') }}"
                    class="btn primary">

                    ← Volver

                </a>

                <a
                    href="{{ route('reportes.ventas.pdf') }}"
                    class="btn danger">

                    PDF

                </a>

                <a
                    href="{{ route('reportes.ventas.excel') }}"
                    class="btn success">

                    Excel

                </a>

            </div>

        </div>


        <div class="panel">

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>
                                N.º
                            </th>

                            <th>
                                Fecha
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Pagado
                            </th>

                            <th>
                                Saldo
                            </th>

                            <th>
                                Medio de pago
                            </th>

                            <th>
                                Estado pago
                            </th>

                            <th>
                                Estado venta
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($ventas as $venta)

                        <tr>

                            <td>
                                #{{ $venta->id }}
                            </td>

                            <td>
                                {{ $venta->fecha?->format('d/m/Y H:i') }}
                            </td>

                            <td>

                                <strong>
                                    S/
                                    {{ number_format($venta->total,2) }}
                                </strong>

                            </td>

                            <td>
                                S/
                                {{ number_format($venta->monto_pagado,2) }}
                            </td>

                            <td>
                                S/
                                {{ number_format($venta->saldo_pendiente,2) }}
                            </td>

                            <td>
                                {{ $venta->medio_pago }}
                            </td>

                            <td>

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

                            <td>

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
                                style="text-align:center;padding:30px;">

                                No existen ventas registradas.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Reporte de Movimientos</title>

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
            text-decoration: none;
            color: white;
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

        .entrada {
            color: #16a34a;
            font-weight: bold;
        }

        .salida {
            color: #dc2626;
            font-weight: bold;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">

            <div>

                <h1>
                    Reporte de Movimientos
                </h1>

                <p>
                    Historial de entradas y salidas de inventario
                </p>

            </div>

            <div class="acciones">

                <a
                    href="{{ route('reportes.index') }}"
                    class="btn primary">

                    ← Volver

                </a>

                <a
                    href="{{ route('reportes.movimientos.pdf') }}"
                    class="btn danger">

                    PDF

                </a>

                <a
                    href="{{ route('reportes.movimientos.excel') }}"
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
                                Fecha
                            </th>

                            <th>
                                Código
                            </th>

                            <th>
                                Producto
                            </th>

                            <th>
                                Tipo
                            </th>

                            <th>
                                Cantidad
                            </th>

                            <th>
                                Observación
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($movimientos as $movimiento)

                        <tr>

                            <td>
                                {{ $movimiento->fecha?->format(
                                'd/m/Y H:i'
                            ) }}
                            </td>

                            <td>
                                {{ $movimiento->producto->codigo ?? '-' }}
                            </td>

                            <td>
                                {{ $movimiento->producto->descripcion ?? '-' }}
                            </td>

                            <td>

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

                            <td>
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
                                style="text-align:center;padding:30px;">

                                No hay movimientos registrados.

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
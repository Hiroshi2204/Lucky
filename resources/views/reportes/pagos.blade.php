<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Reporte de Pagos</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .container {
            max-width: 1300px;
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

        .monto {
            font-weight: bold;
            color: #166534;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">

            <div>

                <h1>
                    Reporte de Pagos
                </h1>

                <p>
                    Historial de pagos registrados
                </p>

            </div>

            <div class="acciones">

                <a
                    href="{{ route('reportes.index') }}"
                    class="btn primary">

                    ← Volver

                </a>

                <a
                    href="{{ route('reportes.pagos.pdf') }}"
                    class="btn danger">

                    PDF

                </a>

                <a
                    href="{{ route('reportes.pagos.excel') }}"
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
                                Venta
                            </th>

                            <th>
                                Medio de pago
                            </th>

                            <th>
                                Monto
                            </th>

                            <th>
                                Observación
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($pagos as $pago)

                        <tr>

                            <td>

                                {{ $pago->fecha?->format(
    'd/m/Y H:i'
) }}

                            </td>

                            <td>

                                <a
                                    href="{{ route(
    'ventas.show',
    $pago->venta_id
) }}">

                                    Venta #{{ $pago->venta_id }}

                                </a>

                            </td>

                            <td>

                                {{ $pago->medio_pago }}

                                @if($pago->medio_pago_otro)

                                <br>

                                <small>
                                    {{ $pago->medio_pago_otro }}
                                </small>

                                @endif

                            </td>

                            <td>

                                <span class="monto">

                                    S/
                                    {{ number_format(
    $pago->monto,
    2
) }}

                                </span>

                            </td>

                            <td>

                                {{ $pago->observacion ?: '-' }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="5"
                                style="text-align:center;padding:30px;">

                                No existen pagos registrados.

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
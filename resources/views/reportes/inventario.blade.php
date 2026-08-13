<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Reporte de Inventario</title>

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
            gap: 15px;
        }

        .header h1 {
            font-size: 27px;
        }

        .header p {
            color: #6b7280;
            margin-top: 5px;
        }

        .acciones {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-size: 14px;
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
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
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
            color: #6b7280;
            text-align: left;
            padding: 12px;
            font-size: 13px;
        }

        td {
            padding: 12px;
            border-top: 1px solid #eee;
        }

        .stock {
            font-weight: bold;
        }

        .sin-stock {
            color: #dc2626;
        }

        .stock-bajo {
            color: #d97706;
        }

        @media(max-width:700px) {

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">

            <div>

                <h1>
                    Reporte de Inventario
                </h1>

                <p>
                    Stock actual de productos
                </p>

            </div>

            <div class="acciones">

                <a
                    href="{{ route('reportes.index') }}"
                    class="btn primary">

                    ← Volver

                </a>

                <a
                    href="{{ route('reportes.inventario.pdf') }}"
                    class="btn danger">

                    PDF

                </a>

                <a
                    href="{{ route('reportes.inventario.excel') }}"
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
                                #
                            </th>

                            <th>
                                Código
                            </th>

                            <th>
                                Descripción
                            </th>

                            <th>
                                Espesor
                            </th>

                            <th>
                                Stock actual
                            </th>

                            <th>
                                Estado
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($productos as $producto)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <strong>
                                    {{ $producto->codigo }}
                                </strong>
                            </td>

                            <td>
                                {{ $producto->descripcion }}
                            </td>

                            <td>
                                {{ number_format(
                                $producto->espesor,
                                3
                            ) }}
                            </td>

                            <td>

                                <span class="stock
                                @if($producto->stock_actual <= 0)
                                    sin-stock
                                @elseif($producto->stock_actual <= 10)
                                    stock-bajo
                                @endif">

                                    {{ number_format(
                                    $producto->stock_actual,
                                    3
                                ) }}

                                </span>

                            </td>

                            <td>

                                @if($producto->estado)

                                Activo

                                @else

                                Inactivo

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="6"
                                style="text-align:center;padding:30px;">

                                No hay productos registrados.

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
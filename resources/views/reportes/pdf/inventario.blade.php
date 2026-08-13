<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Inventario</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .fecha {
            text-align: right;
            font-size: 9px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1f2937;
            color: white;
            padding: 8px;
            border: 1px solid #333;
            text-align: left;
        }

        td {
            padding: 7px;
            border: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .activo {
            color: #166534;
            font-weight: bold;
        }

        .inactivo {
            color: #991b1b;
            font-weight: bold;
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
            REPORTE DE INVENTARIO
        </h1>

        <p>
            Sistema de Gestión de Inventario
        </p>

    </div>

    <div class="fecha">

        Generado:
        {{ now()->format('d/m/Y H:i:s') }}

    </div>


    <table>

        <thead>

            <tr>

                <th style="width: 12%;">
                    Código
                </th>

                <th style="width: 30%;">
                    Descripción
                </th>

                <th style="width: 12%;">
                    Espesor
                </th>

                <th style="width: 15%;">
                    Stock actual
                </th>

                <th style="width: 15%;">
                    Estado
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($productos as $producto)

            <tr>

                <td>
                    {{ $producto->codigo }}
                </td>

                <td>
                    {{ $producto->descripcion }}
                </td>

                <td class="text-center">

                    {{ number_format(
                            $producto->espesor,
                            3
                        ) }}

                </td>

                <td class="text-right">

                    {{ number_format(
                            $producto->stock_actual,
                            3
                        ) }}

                </td>

                <td class="text-center">

                    @if($producto->estado)

                    <span class="activo">
                        ACTIVO
                    </span>

                    @else

                    <span class="inactivo">
                        INACTIVO
                    </span>

                    @endif

                </td>

            </tr>

            @empty

            <tr>

                <td
                    colspan="5"
                    class="text-center">

                    No existen productos registrados.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>


    <div class="total">

        Total de productos:
        {{ $productos->count() }}

    </div>


    <div class="footer">

        Sistema de Gestión de Inventario -
        Reporte generado automáticamente

    </div>

</body>

</html>
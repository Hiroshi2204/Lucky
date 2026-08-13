<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $producto->codigo }} - Producto</title>

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
            max-width: 1100px;
            margin: auto;
            padding: 25px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
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
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
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

        .btn-warning {
            background: #d97706;
            color: white;
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .panel {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,.06);
        }

        .panel-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .campo label {
            display: block;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .campo strong {
            font-size: 17px;
        }

        .descripcion {
            grid-column: 1 / -1;
        }

        .estado {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .activo {
            background: #dcfce7;
            color: #166534;
        }

        .inactivo {
            background: #fee2e2;
            color: #991b1b;
        }

        .stock-panel {
            text-align: center;
        }

        .stock-label {
            color: #6b7280;
            font-size: 14px;
        }

        .stock-value {
            font-size: 48px;
            font-weight: bold;
            margin: 15px 0 5px;
            color: #16a34a;
        }

        .stock-unidad {
            color: #6b7280;
        }

        .stock-status {
            margin-top: 20px;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
        }

        .stock-ok {
            background: #dcfce7;
            color: #166534;
        }

        .stock-zero {
            background: #fef3c7;
            color: #92400e;
        }

        .movimientos {
            margin-top: 20px;
        }

        .empty {
            text-align: center;
            padding: 35px 15px;
            color: #6b7280;
        }

        .empty p {
            margin-top: 10px;
        }

        .footer-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media(max-width:800px) {

            .container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .acciones {
                width: 100%;
                flex-direction: column;
            }

            .acciones .btn {
                width: 100%;
                text-align: center;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .info {
                grid-template-columns: 1fr;
            }

            .descripcion {
                grid-column: auto;
            }

            .footer-actions {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }

        }
        .table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    text-align: left;
    padding: 12px;
    background: #f9fafb;
    color: #6b7280;
    font-size: 13px;
}

td {
    padding: 12px;
    border-top: 1px solid #eee;
}

.movimiento {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 12px;
}

.entrada {
    background: #dcfce7;
    color: #166534;
}

.salida {
    background: #fee2e2;
    color: #991b1b;
}

.cantidad-entrada {
    color: #16a34a;
}

.cantidad-salida {
    color: #dc2626;
}

    </style>

</head>

<body>

<div class="container">


    {{-- ENCABEZADO --}}

    <div class="header">

        <div>

            <h1>
                {{ $producto->codigo }}
            </h1>

            <p>
                Detalle del producto
            </p>

        </div>


        <div class="acciones">

            <a
                href="{{ route(
                    'productos.edit',
                    $producto
                ) }}"
                class="btn btn-warning"
            >
                Editar
            </a>

            <a
                href="{{ route(
                    'productos.index'
                ) }}"
                class="btn btn-secondary"
            >
                ← Volver
            </a>

        </div>

    </div>


    {{-- INFORMACIÓN Y STOCK --}}

    <div class="grid">


        {{-- INFORMACIÓN --}}

        <div class="panel">

            <div class="panel-title">

                Información del producto

            </div>


            <div class="info">


                <div class="campo">

                    <label>
                        Código
                    </label>

                    <strong>
                        {{ $producto->codigo }}
                    </strong>

                </div>


                <div class="campo">

                    <label>
                        Estado
                    </label>

                    @if($producto->estado)

                        <span class="estado activo">
                            Activo
                        </span>

                    @else

                        <span class="estado inactivo">
                            Inactivo
                        </span>

                    @endif

                </div>


                <div class="campo descripcion">

                    <label>
                        Descripción
                    </label>

                    <strong>
                        {{ $producto->descripcion }}
                    </strong>

                </div>


                <div class="campo">

                    <label>
                        Espesor
                    </label>

                    <strong>
                        {{ number_format(
                            $producto->espesor,
                            3
                        ) }}
                    </strong>

                </div>


                <div class="campo">

                    <label>
                        Fecha de registro
                    </label>

                    <strong>
                        {{ $producto->created_at->format(
                            'd/m/Y H:i'
                        ) }}
                    </strong>

                </div>


                <div class="campo">

                    <label>
                        Última actualización
                    </label>

                    <strong>
                        {{ $producto->updated_at->format(
                            'd/m/Y H:i'
                        ) }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- STOCK --}}

        <div class="panel stock-panel">

            <div class="panel-title">

                Stock actual

            </div>


            <div class="stock-label">

                Cantidad disponible

            </div>


            <div class="stock-value">

                {{ number_format(
                    $stock,
                    3
                ) }}

            </div>


            <div class="stock-unidad">

                unidades

            </div>


            @if($stock > 0)

                <div class="stock-status stock-ok">

                    Stock disponible

                </div>

            @else

                <div class="stock-status stock-zero">

                    Sin stock disponible

                </div>

            @endif

        </div>

    </div>


    {{-- MOVIMIENTOS --}}

<div class="panel movimientos">

    <div class="panel-title">

        Historial de movimientos

    </div>


    @if($movimientos->count() > 0)

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            Fecha
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

                    @foreach($movimientos as $movimiento)

                        <tr>

                            <td>

                                {{ $movimiento->fecha->format(
                                    'd/m/Y H:i'
                                ) }}

                            </td>


                            <td>

                                @if($movimiento->tipo === 'ENTRADA')

                                    <span class="movimiento entrada">
                                        ENTRADA
                                    </span>

                                @else

                                    <span class="movimiento salida">
                                        SALIDA
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($movimiento->tipo === 'ENTRADA')

                                    <strong class="cantidad-entrada">

                                        +{{ number_format(
                                            $movimiento->cantidad,
                                            3
                                        ) }}

                                    </strong>

                                @else

                                    <strong class="cantidad-salida">

                                        -{{ number_format(
                                            $movimiento->cantidad,
                                            3
                                        ) }}

                                    </strong>

                                @endif

                            </td>


                            <td>

                                {{ $movimiento->observacion ?: 'Sin observación' }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty">

            <strong>
                Sin movimientos
            </strong>

            <p>
                Este producto todavía no tiene
                entradas ni salidas registradas.
            </p>

        </div>

    @endif

</div>


    {{-- ACCIONES INFERIORES --}}

    <div class="footer-actions">

        <a
            href="{{ route('productos.index') }}"
            class="btn btn-secondary"
        >
            ← Volver a productos
        </a>


        @if($producto->estado)

            <form
                method="POST"
                action="{{ route(
                    'productos.destroy',
                    $producto
                ) }}"
                onsubmit="return confirm(
                    '¿Deseas desactivar este producto?'
                )"
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-warning"
                >
                    Desactivar producto
                </button>

            </form>

        @endif

    </div>

</div>

</body>

</html>
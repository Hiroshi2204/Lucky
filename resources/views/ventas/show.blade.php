<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Venta #{{ $venta->id }}
    </title>

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
            max-width: 1200px;
            margin: auto;
            padding: 25px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
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
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        }

        .panel h2 {
            margin-bottom: 18px;
            font-size: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .info-box {
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .info-box small {
            display: block;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .info-box strong {
            font-size: 18px;
        }

        .total {
            color: #2563eb;
        }

        .pagado {
            color: #166534;
        }

        .pendiente {
            color: #dc2626;
        }

        .estado {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .activo {
            background: #dcfce7;
            color: #166534;
        }

        .anulado {
            background: #fee2e2;
            color: #991b1b;
        }

        .cancelado {
            background: #dcfce7;
            color: #166534;
        }

        .parcial {
            background: #fef3c7;
            color: #92400e;
        }

        .pendiente-estado {
            background: #fee2e2;
            color: #991b1b;
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

        .text-right {
            text-align: right;
        }

        .acciones {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
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

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        @media(max-width: 800px) {

            .container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-grid {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media(max-width: 500px) {

            .info-grid {
                grid-template-columns: 1fr;
            }

            .acciones {
                flex-direction: column;
            }

            .acciones .btn {
                width: 100%;
                text-align: center;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        {{-- HEADER --}}

        <div class="header">

            <div>

                <h1>
                    Venta #{{ $venta->id }}
                </h1>

                <p>
                    Detalle de la venta
                </p>

            </div>

            <div class="acciones">

                <a
                    href="{{ route('ventas.index') }}"
                    class="btn btn-secondary">
                    ← Volver
                </a>

                @if(
                $venta->estado === 'ACTIVA' &&
                $venta->saldo_pendiente > 0
                )

                <a
                    href="{{ route('pagos.create', $venta) }}"
                    class="btn btn-primary">
                    + Registrar pago
                </a>

                @endif

            </div>

        </div>


        {{-- MENSAJES --}}

        @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif


        @if($errors->any())

        <div class="alert alert-error">

            @foreach($errors->all() as $error)

            <div>
                {{ $error }}
            </div>

            @endforeach

        </div>

        @endif


        {{-- RESUMEN --}}

        <div class="panel">

            <h2>
                Resumen de la venta
            </h2>

            <div class="info-grid">

                <div class="info-box">

                    <small>
                        Total
                    </small>

                    <strong class="total">
                        S/
                        {{ number_format($venta->total, 2) }}
                    </strong>

                </div>


                <div class="info-box">

                    <small>
                        Total pagado
                    </small>

                    <strong class="pagado">
                        S/
                        {{ number_format($venta->monto_pagado, 2) }}
                    </strong>

                </div>


                <div class="info-box">

                    <small>
                        Saldo pendiente
                    </small>

                    <strong class="pendiente">
                        S/
                        {{ number_format($venta->saldo_pendiente, 2) }}
                    </strong>

                </div>


                <div class="info-box">

                    <small>
                        Estado de pago
                    </small>

                    @if($venta->estado_pago === 'CANCELADO')

                    <span class="estado cancelado">
                        CANCELADO
                    </span>

                    @elseif($venta->estado_pago === 'PARCIAL')

                    <span class="estado parcial">
                        PARCIAL
                    </span>

                    @else

                    <span class="estado pendiente-estado">
                        {{ $venta->estado_pago }}
                    </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- INFORMACIÓN GENERAL --}}

        <div class="panel">

            <h2>
                Información general
            </h2>

            <div class="info-grid">

                <div class="info-box">

                    <small>
                        Fecha
                    </small>

                    <strong>
                        {{ $venta->fecha->format('d/m/Y H:i') }}
                    </strong>

                </div>

                <div class="info-box">

                    <small>
                        Medio de pago inicial
                    </small>

                    <strong>
                        {{ $venta->medio_pago }}
                    </strong>

                </div>

                <div class="info-box">

                    <small>
                        Estado de venta
                    </small>

                    @if($venta->estado === 'ACTIVA')

                    <span class="estado activo">
                        ACTIVA
                    </span>

                    @else

                    <span class="estado anulado">
                        ANULADA
                    </span>

                    @endif

                </div>

                <div class="info-box">

                    <small>
                        Observación
                    </small>

                    <strong>
                        {{ $venta->observacion ?: '-' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- PRODUCTOS --}}

        <div class="panel">

            <h2>
                Productos vendidos
            </h2>

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Código
                            </th>

                            <th>
                                Descripción
                            </th>

                            <th>
                                Espesor
                            </th>

                            <th class="text-right">
                                Cantidad
                            </th>

                            <th class="text-right">
                                Precio unitario
                            </th>

                            <th class="text-right">
                                Total
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($venta->detalles as $detalle)

                        <tr>

                            <td>
                                <strong>
                                    {{ $detalle->producto->codigo }}
                                </strong>
                            </td>

                            <td>
                                {{ $detalle->producto->descripcion }}
                            </td>

                            <td>
                                {{ number_format(
                                    $detalle->producto->espesor,
                                    3
                                ) }}
                            </td>

                            <td class="text-right">
                                {{ number_format(
                                    $detalle->cantidad,
                                    3
                                ) }}
                            </td>

                            <td class="text-right">
                                S/
                                {{ number_format(
                                    $detalle->precio_unitario,
                                    2
                                ) }}
                            </td>

                            <td class="text-right">

                                <strong>
                                    S/
                                    {{ number_format(
                                        $detalle->precio_total,
                                        2
                                    ) }}
                                </strong>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        {{-- HISTORIAL DE PAGOS --}}

        <div class="panel">

            <h2>
                Historial de pagos
            </h2>

            @if($venta->pagos->count())

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Fecha
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

                        @foreach($venta->pagos->sortByDesc('fecha') as $pago)

                        <tr>

                            <td>
                                {{ $pago->fecha->format(
                                        'd/m/Y H:i'
                                    ) }}
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

                        @endforeach

                    </tbody>

                </table>

            </div>

            @else

            <p style="color:#6b7280;">
                Esta venta todavía no tiene pagos registrados.
            </p>

            @endif

        </div>


        {{-- ANULAR --}}

        @if($venta->estado === 'ACTIVA')

        <div class="panel">

            <form
                method="POST"
                action="{{ route(
                    'ventas.anular',
                    $venta
                ) }}"
                onsubmit="return confirm(
                    '¿Estás seguro de anular esta venta? El stock será devuelto.'
                )">

                @csrf

                <button
                    type="submit"
                    class="btn btn-danger">
                    Anular venta
                </button>

            </form>

        </div>

        @endif

    </div>

</body>

</html>
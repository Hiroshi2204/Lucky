<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Pagos - Venta #{{ $venta->id }}</title>

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
            gap: 15px;
            margin-bottom: 25px;
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
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        }

        .resumen {
            display: grid;
            grid-template-columns:
                repeat(4, 1fr);

            gap: 15px;
        }

        .card {
            padding: 20px;
            border-radius: 10px;
            background: #f9fafb;
        }

        .card span {
            display: block;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .card strong {
            font-size: 24px;
        }

        .total {
            color: #1d4ed8;
        }

        .pagado {
            color: #15803d;
        }

        .saldo {
            color: #dc2626;
        }

        .estado {
            margin-top: 8px;
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .estado-cancelado {
            background: #dcfce7;
            color: #166534;
        }

        .estado-parcial {
            background: #fef3c7;
            color: #92400e;
        }

        .estado-pendiente {
            background: #fee2e2;
            color: #991b1b;
        }

        .estado-otro {
            background: #e5e7eb;
            color: #374151;
        }

        .acciones {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
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

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .btn:hover {
            opacity: .9;
        }

        .alert-success {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
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

        th,
        td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
            font-size: 13px;
        }

        td {
            font-size: 14px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
        }

        @media(max-width: 800px) {

            .resumen {
                grid-template-columns: 1fr 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

        }

        @media(max-width: 500px) {

            .container {
                padding: 15px;
            }

            .resumen {
                grid-template-columns: 1fr;
            }

            .acciones {
                flex-direction: column;
                align-items: stretch;
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
                    Pagos de la venta #{{ $venta->id }}
                </h1>

                <p>
                    Historial de pagos y saldo pendiente
                </p>

            </div>

            <!-- <a
                href="{{ route('ventas.show', $venta) }}"
                class="btn btn-secondary">
                ← Volver a venta
            </a> -->

        </div>


        {{-- MENSAJES --}}

        @if(session('success'))

        <div class="alert-success">
            {{ session('success') }}
        </div>

        @endif


        @if($errors->any())

        <div class="alert-error">

            @foreach($errors->all() as $error)

            <div>
                {{ $error }}
            </div>

            @endforeach

        </div>

        @endif


        {{-- RESUMEN --}}

        <div class="panel">

            <div class="resumen">

                <div class="card">

                    <span>
                        Total de venta
                    </span>

                    <strong class="total">
                        S/
                        {{ number_format($venta->total, 2) }}
                    </strong>

                </div>


                <div class="card">

                    <span>
                        Total pagado
                    </span>

                    <strong class="pagado">
                        S/
                        {{ number_format($venta->monto_pagado, 2) }}
                    </strong>

                </div>


                <div class="card">

                    <span>
                        Saldo pendiente
                    </span>

                    <strong class="saldo">
                        S/
                        {{ number_format($venta->saldo_pendiente, 2) }}
                    </strong>

                </div>


                <div class="card">

                    <span>
                        Estado
                    </span>

                    @php

                    $claseEstado = match($venta->estado_pago) {

                    'CANCELADO' =>
                    'estado-cancelado',

                    'PARCIAL' =>
                    'estado-parcial',

                    'PENDIENTE' =>
                    'estado-pendiente',

                    default =>
                    'estado-otro',

                    };

                    @endphp

                    <span class="estado {{ $claseEstado }}">

                        {{ $venta->estado_pago }}

                    </span>

                </div>

            </div>

        </div>


        {{-- ACCIONES --}}

        <div class="acciones">

            <a
                href="{{ route('ventas.show', $venta) }}"
                class="btn btn-secondary">
                Ver venta
            </a>


            @if(
            $venta->estado !== 'ANULADA' &&
            $venta->saldo_pendiente > 0
            )

            <a
                href="{{ route('pagos.create', $venta) }}"
                class="btn btn-success">
                + Registrar pago
            </a>

            @endif

        </div>


        {{-- TABLA --}}

        <div class="panel">

            <h2 style="margin-bottom:20px;">
                Historial de pagos
            </h2>

            <div class="table-container">

                @if($pagos->count())

                <table>

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Fecha
                            </th>

                            <th>
                                Monto
                            </th>

                            <th>
                                Medio de pago
                            </th>

                            <th>
                                Observación
                            </th>

                            <!-- <th>
                                Acción
                            </th> -->

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($pagos as $pago)

                        <tr>

                            <td>
                                {{ $pago->id }}
                            </td>

                            <td>
                                {{ $pago->fecha->format('d/m/Y H:i') }}
                            </td>

                            <td>

                                <strong>
                                    S/
                                    {{ number_format($pago->monto, 2) }}
                                </strong>

                            </td>

                            <td>

                                {{ $pago->medio_pago }}

                                @if($pago->medio_pago === 'OTRO')

                                <br>

                                <small>
                                    {{ $pago->medio_pago_otro }}
                                </small>

                                @endif

                            </td>

                            <td>
                                {{ $pago->observacion ?: '-' }}
                            </td>

                            <!-- <td>

                                <a
                                    href="{{ route('pagos.show', $pago) }}"
                                    class="btn btn-primary">
                                    Ver
                                </a>

                            </td> -->

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                @else

                <div class="empty">

                    Esta venta todavía no tiene pagos registrados.

                </div>

                @endif

            </div>

        </div>

    </div>

</body>

</html>
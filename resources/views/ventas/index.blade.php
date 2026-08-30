@extends('layouts.app')

@section('title', 'Ventas')

@section('styles')


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
        max-width: 1400px;
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

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
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

    .btn-success {
        background: #16a34a;
        color: white;
    }

    .btn-warning {
        background: #d97706;
        color: white;
    }

    .panel {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }

    .filtros {
        display: grid;
        grid-template-columns:
            1fr 1fr 1fr 1fr auto auto;

        gap: 10px;
        margin-bottom: 20px;
    }

    .filtros input,
    .filtros select {
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        width: 100%;
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

    .acciones {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .estado {
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 12px;
    }

    .activa {
        background: #dcfce7;
        color: #166534;
    }

    .anulada {
        background: #fee2e2;
        color: #991b1b;
    }

    .pagado {
        background: #dcfce7;
        color: #166534;
    }

    .pendiente {
        background: #fef3c7;
        color: #92400e;
    }

    .parcial {
        background: #dbeafe;
        color: #1e40af;
    }

    .total {
        font-weight: bold;
        font-size: 16px;
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

    .pagination {
        margin-top: 20px;
    }

    @media(max-width:900px) {

        .filtros {
            grid-template-columns: 1fr 1fr;
        }

    }

    @media(max-width:700px) {

        .container {
            padding: 15px;
        }

        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .filtros {
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

@endsection


@section('content')

<div class="container">

    <div class="header">

        <div>

            <h1>Ventas</h1>

            <p>
                Gestión de ventas y salidas de inventario
            </p>

        </div>

        <div>

            <a
                href="{{ route('ventas.create') }}"
                class="btn btn-primary">
                + Nueva venta
            </a>

        </div>

    </div>


    {{-- MENSAJE --}}

    @if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

    @endif


    <div class="panel">

        {{-- FILTROS --}}

        <form
            method="GET"
            action="{{ route('ventas.index') }}"
            class="filtros">

            <select name="medio_pago">

                <option value="">
                    Todos los medios de pago
                </option>

                <option
                    value="EFECTIVO"
                    @selected(request('medio_pago')==='EFECTIVO' )>
                    Efectivo
                </option>

                <option
                    value="DEPOSITO"
                    @selected(request('medio_pago')==='DEPOSITO' )>
                    Depósito
                </option>

                <option
                    value="TRANSFERENCIA"
                    @selected(request('medio_pago')==='TRANSFERENCIA' )>
                    Transferencia
                </option>

                <option
                    value="OTRO"
                    @selected(request('medio_pago')==='OTRO' )>
                    Otro
                </option>

            </select>


            <select name="estado_pago">

                <option value="">
                    Todos los estados
                </option>

                <option
                    value="CANCELADO"
                    @selected(request('estado_pago')==='CANCELADO' )>
                    Cancelado
                </option>

                <option
                    value="PENDIENTE"
                    @selected(request('estado_pago')==='PENDIENTE' )>
                    Pendiente
                </option>

                <option
                    value="PARCIAL"
                    @selected(request('estado_pago')==='PARCIAL' )>
                    Parcial
                </option>

                <option
                    value="OTRO"
                    @selected(request('estado_pago')==='OTRO' )>
                    Otro
                </option>

            </select>


            <input
                type="date"
                name="fecha_inicio"
                value="{{ request('fecha_inicio') }}">


            <input
                type="date"
                name="fecha_fin"
                value="{{ request('fecha_fin') }}">


            <button
                type="submit"
                class="btn btn-primary">
                Filtrar
            </button>


            <a
                href="{{ route('ventas.index') }}"
                class="btn btn-secondary">
                Limpiar
            </a>

        </form>


        {{-- TABLA --}}

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
                            Medio de pago
                        </th>

                        <th>
                            Estado de pago
                        </th>

                        <th>
                            Pagado
                        </th>

                        <th>
                            Saldo
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($ventas as $venta)

                    <tr>

                        <td>
                            <strong>
                                #{{ $venta->id }}
                            </strong>
                        </td>

                        <td>
                            {{ $venta->fecha?->format('d/m/Y H:i') }}
                        </td>

                        <td class="total">

                            S/
                            {{ number_format(
                                    $venta->total,
                                    2
                                ) }}

                        </td>

                        <td>

                            {{ $venta->medio_pago }}

                            @if($venta->medio_pago === 'OTRO'
                            && $venta->medio_pago_otro)

                            <br>

                            <small>
                                {{ $venta->medio_pago_otro }}
                            </small>

                            @endif

                        </td>

                        <td>

                            @if($venta->estado_pago === 'CANCELADO')

                            <span class="estado pagado">
                                Cancelado
                            </span>

                            @elseif($venta->estado_pago === 'PENDIENTE')

                            <span class="estado pendiente">
                                Pendiente
                            </span>

                            @elseif($venta->estado_pago === 'PARCIAL')

                            <span class="estado parcial">
                                Parcial
                            </span>

                            @else

                            <span class="estado pendiente">
                                {{ $venta->estado_pago }}
                            </span>

                            @endif

                        </td>

                        <td>

                            S/
                            {{ number_format(
                                    $venta->monto_pagado,
                                    2
                                ) }}

                        </td>

                        <td>

                            S/
                            {{ number_format(
                                    $venta->saldo_pendiente,
                                    2
                                ) }}

                        </td>

                        <td>

                            @if($venta->estado === 'ACTIVA')

                            <span class="estado activa">
                                Activa
                            </span>

                            @else

                            <span class="estado anulada">
                                Anulada
                            </span>

                            @endif

                        </td>

                        <td>

                            <div class="acciones">

                                {{-- VER VENTA --}}
                                <a
                                    href="{{ route('ventas.show', $venta) }}"
                                    class="btn btn-secondary">
                                    Ver
                                </a>


                                {{-- PAGOS --}}
                                @if(
                                $venta->estado === 'ACTIVA'&&
                                $venta->saldo_pendiente > 0
                                )

                                <a
                                    href="{{ route('pagos.index', $venta) }}"
                                    class="btn btn-success">
                                    Pagos
                                </a>

                                @endif


                                {{-- ANULAR --}}
                                @if($venta->estado === 'ACTIVA')

                                <form
                                    method="POST"
                                    action="{{ route('ventas.anular', $venta) }}">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm(
                                                    '¿Deseas anular esta venta? El stock será devuelto.'
                                                )">

                                        Anular

                                    </button>

                                </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="9"
                            style="text-align:center;padding:30px;">
                            No se encontraron ventas.
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}

        <div class="pagination">

            {{ $ventas->links() }}

        </div>

    </div>

</div>

@endsection
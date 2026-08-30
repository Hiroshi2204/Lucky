@extends('layouts.app')

@section('title', 'Reportes')

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
        max-width: 1200px;
        margin: auto;
        padding: 25px;
    }

    .header {
        margin-bottom: 25px;
    }

    .header h1 {
        font-size: 28px;
    }

    .header p {
        margin-top: 5px;
        color: #6b7280;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }

    .card h2 {
        margin-bottom: 8px;
        font-size: 20px;
    }

    .card-description {
        color: #6b7280;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .filtros {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 15px;
    }

    .campo {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .campo label {
        font-size: 13px;
        font-weight: bold;
        color: #374151;
    }

    input,
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    .acciones {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-pdf {
        background: #dc2626;
        color: white;
    }

    .btn-excel {
        background: #16a34a;
        color: white;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    @media(max-width: 800px) {

        .grid {
            grid-template-columns: 1fr;
        }

    }

    @media(max-width: 500px) {

        .container {
            padding: 15px;
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

        <h1>
            Reportes
        </h1>

        <p>
            Generación de reportes del sistema
        </p>

    </div>


    <div class="grid">


        {{-- ===================================================== --}}
        {{-- INVENTARIO --}}
        {{-- ===================================================== --}}

        <div class="card">

            <h2>
                📦 Inventario
            </h2>

            <div class="card-description">
                Consulta el stock actual de todos los productos.
            </div>

            <form
                method="GET"
                class="form-reporte"
                data-pdf="{{ route('reportes.inventario.pdf') }}"
                data-excel="{{ route('reportes.inventario.excel') }}">

                <div class="filtros">

                    <div class="campo">

                        <label>
                            Estado
                        </label>

                        <select name="estado">

                            <option value="">
                                Todos
                            </option>

                            <option value="1">
                                Activos
                            </option>

                            <option value="0">
                                Inactivos
                            </option>

                        </select>

                    </div>

                </div>

                <div class="acciones">

                    <button
                        type="button"
                        class="btn btn-pdf"
                        onclick="generarReporte(this, 'pdf')">

                        📄 PDF

                    </button>

                    <button
                        type="button"
                        class="btn btn-excel"
                        onclick="generarReporte(this, 'excel')">

                        📊 Excel

                    </button>

                </div>

            </form>

        </div>


        {{-- ===================================================== --}}
        {{-- MOVIMIENTOS --}}
        {{-- ===================================================== --}}

        <div class="card">

            <h2>
                🔄 Movimientos
            </h2>

            <div class="card-description">
                Reporte de entradas y salidas del inventario.
            </div>

            <form
                method="GET"
                class="form-reporte"
                data-pdf="{{ route('reportes.movimientos.pdf') }}"
                data-excel="{{ route('reportes.movimientos.excel') }}">

                <div class="filtros">

                    <div class="campo">

                        <label>
                            Fecha inicio
                        </label>

                        <input
                            type="date"
                            name="fecha_inicio">

                    </div>

                    <div class="campo">

                        <label>
                            Fecha fin
                        </label>

                        <input
                            type="date"
                            name="fecha_fin">

                    </div>

                    <div class="campo">

                        <label>
                            Tipo
                        </label>

                        <select name="tipo">

                            <option value="">
                                Todos
                            </option>

                            <option value="ENTRADA">
                                Entrada
                            </option>

                            <option value="SALIDA">
                                Salida
                            </option>

                        </select>

                    </div>

                </div>

                <div class="acciones">

                    <button
                        type="button"
                        class="btn btn-pdf"
                        onclick="generarReporte(this, 'pdf')">

                        📄 PDF

                    </button>

                    <button
                        type="button"
                        class="btn btn-excel"
                        onclick="generarReporte(this, 'excel')">

                        📊 Excel

                    </button>

                </div>

            </form>

        </div>


        {{-- ===================================================== --}}
        {{-- VENTAS --}}
        {{-- ===================================================== --}}

        <div class="card">

            <h2>
                🛒 Ventas
            </h2>

            <div class="card-description">
                Reporte de ventas realizadas y su estado de pago.
            </div>

            <form
                method="GET"
                class="form-reporte"
                data-pdf="{{ route('reportes.ventas.pdf') }}"
                data-excel="{{ route('reportes.ventas.excel') }}">

                <div class="filtros">

                    <div class="campo">

                        <label>
                            Fecha inicio
                        </label>

                        <input
                            type="date"
                            name="fecha_inicio">

                    </div>

                    <div class="campo">

                        <label>
                            Fecha fin
                        </label>

                        <input
                            type="date"
                            name="fecha_fin">

                    </div>

                    <div class="campo">

                        <label>
                            Estado de venta
                        </label>

                        <select name="estado">

                            <option value="">
                                Todos
                            </option>

                            <option value="ACTIVA">
                                Activas
                            </option>

                            <option value="ANULADA">
                                Anuladas
                            </option>

                        </select>

                    </div>

                    <div class="campo">

                        <label>
                            Estado de pago
                        </label>

                        <select name="estado_pago">

                            <option value="">
                                Todos
                            </option>

                            <option value="CANCELADO">
                                Cancelado
                            </option>

                            <option value="PENDIENTE">
                                Pendiente
                            </option>

                            <option value="PARCIAL">
                                Parcial
                            </option>

                        </select>

                    </div>

                </div>

                <div class="acciones">

                    <button
                        type="button"
                        class="btn btn-pdf"
                        onclick="generarReporte(this, 'pdf')">

                        📄 PDF

                    </button>

                    <button
                        type="button"
                        class="btn btn-excel"
                        onclick="generarReporte(this, 'excel')">

                        📊 Excel

                    </button>

                </div>

            </form>

        </div>


        {{-- ===================================================== --}}
        {{-- PAGOS --}}
        {{-- ===================================================== --}}

        <div class="card">

            <h2>
                💰 Pagos
            </h2>

            <div class="card-description">
                Historial de pagos realizados por los clientes.
            </div>

            <form
                method="GET"
                class="form-reporte"
                data-pdf="{{ route('reportes.pagos.pdf') }}"
                data-excel="{{ route('reportes.pagos.excel') }}">

                <div class="filtros">

                    <div class="campo">

                        <label>
                            Fecha inicio
                        </label>

                        <input
                            type="date"
                            name="fecha_inicio">

                    </div>

                    <div class="campo">

                        <label>
                            Fecha fin
                        </label>

                        <input
                            type="date"
                            name="fecha_fin">

                    </div>

                    <div class="campo">

                        <label>
                            Medio de pago
                        </label>

                        <select name="medio_pago">

                            <option value="">
                                Todos
                            </option>

                            <option value="EFECTIVO">
                                Efectivo
                            </option>

                            <option value="DEPOSITO">
                                Depósito
                            </option>

                            <option value="TRANSFERENCIA">
                                Transferencia
                            </option>

                            <option value="OTRO">
                                Otro
                            </option>

                        </select>

                    </div>

                </div>

                <div class="acciones">

                    <button
                        type="button"
                        class="btn btn-pdf"
                        onclick="generarReporte(this, 'pdf')">

                        📄 PDF

                    </button>

                    <button
                        type="button"
                        class="btn btn-excel"
                        onclick="generarReporte(this, 'excel')">

                        📊 Excel

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
    function generarReporte(button, tipo) {
        const form = button.closest('.form-reporte');

        let url;

        if (tipo === 'pdf') {

            url = form.dataset.pdf;

        } else {

            url = form.dataset.excel;

        }

        const params = new URLSearchParams(
            new FormData(form)
        );

        const queryString = params.toString();

        if (queryString) {

            url += '?' + queryString;

        }

        window.location.href = url;
    }
</script>

@endsection
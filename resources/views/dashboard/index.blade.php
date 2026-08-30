@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
@section('head')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

@endsection

<style>
    /* =========================================================
       DASHBOARD
    ========================================================= */

    .dashboard-container {
        width: 100%;
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .dashboard-header h1 {
        font-size: 28px;
        color: #1f2937;
        margin: 0;
    }

    .dashboard-header p {
        color: #6b7280;
        margin-top: 5px;
        margin-bottom: 0;
    }

    .dashboard-date {
        color: #6b7280;
        font-size: 14px;
        background: white;
        padding: 10px 15px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
    }


    /* =========================================================
       ACCIONES RÁPIDAS
    ========================================================= */

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .quick-action {
        background: white;
        border-radius: 12px;
        padding: 18px;
        text-decoration: none;
        color: #1f2937;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        transition: all .2s ease;
    }

    .quick-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 18px rgba(0, 0, 0, .10);
    }

    .quick-icon {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .quick-title {
        font-weight: bold;
        font-size: 15px;
    }

    .quick-description {
        margin-top: 5px;
        font-size: 12px;
        color: #6b7280;
    }


    /* =========================================================
       CARDS
    ========================================================= */

    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .dashboard-card {
        background: white;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }

    .card-title {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .card-value {
        font-size: 28px;
        font-weight: bold;
        color: #1f2937;
    }

    .card-info {
        margin-top: 8px;
        color: #9ca3af;
        font-size: 13px;
    }


    /* =========================================================
       GRID PRINCIPAL
    ========================================================= */

    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .dashboard-panel {
        background: white;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }

    .dashboard-panel h2 {
        font-size: 18px;
        margin-bottom: 20px;
        color: #1f2937;
    }


    /* =========================================================
       GRÁFICO
    ========================================================= */

    .chart-container {
        position: relative;
        width: 100%;
        height: 350px;
    }

    #ventasChart {
        width: 100% !important;
        height: 100% !important;
    }


    /* =========================================================
       TABLA
    ========================================================= */

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        background: #f9fafb;
        padding: 12px;
        font-size: 13px;
        color: #6b7280;
    }

    td {
        padding: 12px;
        border-top: 1px solid #eee;
        font-size: 14px;
    }

    .stock-bajo {
        font-weight: bold;
        color: #dc2626;
    }

    .sin-stock {
        color: #dc2626;
        font-weight: bold;
    }


    /* =========================================================
       DINERO
    ========================================================= */

    .money-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media(max-width:1100px) {

        .quick-actions {
            grid-template-columns: repeat(3, 1fr);
        }

        .dashboard-cards {
            grid-template-columns: repeat(2, 1fr);
        }

    }


    @media(max-width:900px) {

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

    }


    @media(max-width:700px) {

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .dashboard-header h1 {
            font-size: 24px;
        }

        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }

        .money-grid {
            grid-template-columns: 1fr;
        }

        .chart-container {
            height: 280px;
        }

    }


    @media(max-width:500px) {

        .quick-actions {
            grid-template-columns: 1fr;
        }

        .dashboard-cards {
            grid-template-columns: 1fr;
        }

        .dashboard-card {
            padding: 18px;
        }

        .card-value {
            font-size: 24px;
        }

    }
</style>


<div class="dashboard-container">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="dashboard-header">

        <div>

            <h1>
                Dashboard
            </h1>

            <p>
                Resumen general del inventario y ventas
            </p>

        </div>

        <div class="dashboard-date">

            {{ now()->format('d/m/Y H:i') }}

        </div>

    </div>


    {{-- =====================================================
         ACCIONES RÁPIDAS
    ====================================================== --}}

    <div class="quick-actions">


        {{-- PRODUCTOS --}}

        <a
            href="{{ route('productos.index') }}"
            class="quick-action">

            <div class="quick-icon">
                📦
            </div>

            <div class="quick-title">
                Productos
            </div>

            <div class="quick-description">
                Administrar productos
            </div>

        </a>


        {{-- NUEVA ENTRADA --}}

        <a
            href="{{ route('entradas.create') }}"
            class="quick-action">

            <div class="quick-icon">
                📥
            </div>

            <div class="quick-title">
                Nueva entrada
            </div>

            <div class="quick-description">
                Agregar stock
            </div>

        </a>


        {{-- IMPORTAR EXCEL --}}

        <a
            href="{{ route('entradas.importar') }}"
            class="quick-action">

            <div class="quick-icon">
                📊
            </div>

            <div class="quick-title">
                Importar Excel
            </div>

            <div class="quick-description">
                Carga masiva de productos
            </div>

        </a>


        {{-- NUEVA VENTA --}}

        <a
            href="{{ route('ventas.create') }}"
            class="quick-action">

            <div class="quick-icon">
                🛒
            </div>

            <div class="quick-title">
                Nueva venta
            </div>

            <div class="quick-description">
                Registrar venta
            </div>

        </a>


        {{-- REPORTES --}}

        <a
            href="{{ route('reportes.index') }}"
            class="quick-action">

            <div class="quick-icon">
                📈
            </div>

            <div class="quick-title">
                Reportes
            </div>

            <div class="quick-description">
                PDF y Excel
            </div>

        </a>


    </div>


    {{-- =====================================================
         CARDS PRINCIPALES
    ====================================================== --}}

    <div class="dashboard-cards">


        {{-- TOTAL PRODUCTOS --}}

        <div class="dashboard-card">

            <div class="card-title">
                TOTAL PRODUCTOS
            </div>

            <div class="card-value">

                {{ number_format($totalProductos) }}

            </div>

            <div class="card-info">
                Productos registrados
            </div>

        </div>


        {{-- STOCK TOTAL --}}

        <div class="dashboard-card">

            <div class="card-title">
                STOCK TOTAL
            </div>

            <div class="card-value">

                {{ number_format($stockTotal, 2) }}

            </div>

            <div class="card-info">
                Cantidad disponible
            </div>

        </div>


        {{-- VENTAS HOY --}}

        <div class="dashboard-card">

            <div class="card-title">
                VENTAS DE HOY
            </div>

            <div class="card-value">

                S/
                {{ number_format($ventasHoy, 2) }}

            </div>

            <div class="card-info">
                Ventas realizadas hoy
            </div>

        </div>


        {{-- VENTAS MES --}}

        <div class="dashboard-card">

            <div class="card-title">
                VENTAS DEL MES
            </div>

            <div class="card-value">

                S/
                {{ number_format($ventasMes, 2) }}

            </div>

            <div class="card-info">
                {{ now()->translatedFormat('F Y') }}
            </div>

        </div>


    </div>


    {{-- =====================================================
         GRÁFICO + POCO STOCK
    ====================================================== --}}

    <div class="dashboard-grid">


        {{-- GRÁFICO --}}

        <div class="dashboard-panel">

            <h2>
                Ventas de los últimos 7 días
            </h2>

            <div style="position: relative; height: 350px; width: 100%;">

                <canvas id="ventasChart"></canvas>

            </div>

        </div>


        {{-- PRODUCTOS CON POCO STOCK --}}

        <div class="dashboard-panel">

            <h2>
                ⚠ Productos con poco stock
            </h2>

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Código
                            </th>

                            <th>
                                Producto
                            </th>

                            <th>
                                Stock
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($productosPocoStock as $producto)

                        <tr>

                            <td>
                                {{ $producto->codigo }}
                            </td>

                            <td>
                                {{ $producto->descripcion }}
                            </td>

                            <td
                                class="{{ $producto->stock_actual <= 0
                                        ? 'sin-stock'
                                        : 'stock-bajo' }}">

                                {{ number_format(
                                        $producto->stock_actual,
                                        2
                                    ) }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="3">

                                No hay productos con poco stock.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


    </div>


    {{-- =====================================================
         DINERO
    ====================================================== --}}

    <div class="money-grid">


        {{-- DINERO COBRADO --}}

        <div class="dashboard-card">

            <div class="card-title">
                DINERO COBRADO
            </div>

            <div class="card-value">

                S/
                {{ number_format(
                    $dineroCobrado,
                    2
                ) }}

            </div>

            <div class="card-info">
                Total recibido
            </div>

        </div>


        {{-- DINERO PENDIENTE --}}

        <div class="dashboard-card">

            <div class="card-title">
                DINERO PENDIENTE
            </div>

            <div class="card-value">

                S/
                {{ number_format(
                    $dineroPendiente,
                    2
                ) }}

            </div>

            <div class="card-info">
                Total por cobrar
            </div>

        </div>


    </div>


</div>


{{-- =========================================================
     CHART.JS
========================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const ventas = @json($ventasUltimos7Dias);

        console.log('VENTAS DASHBOARD:', ventas);

        const labels = ventas.map(venta => venta.fecha);

        const data = ventas.map(venta => Number(venta.total));

        console.log('LABELS:', labels);
        console.log('DATA:', data);

        const canvas = document.getElementById('ventasChart');

        if (!canvas) {
            console.error('No se encontró el canvas ventasChart');
            return;
        }

        if (typeof Chart === 'undefined') {
            console.error('Chart.js no está cargado');
            return;
        }

        const ctx = canvas.getContext('2d');

        new Chart(ctx, {

            type: 'line',

            data: {
                labels: labels,

                datasets: [{
                    label: 'Ventas',

                    data: data,

                    borderWidth: 3,

                    tension: 0.3,

                    fill: false,

                    pointRadius: 5,

                    pointHoverRadius: 7
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: true
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' S/ ' +
                                    Number(context.raw)
                                    .toFixed(2);
                            }
                        }
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            callback: function(value) {
                                return 'S/ ' + value;
                            }
                        }

                    }

                }

            }

        });

    });
</script>

@endsection
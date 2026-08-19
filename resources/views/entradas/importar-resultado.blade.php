@extends('layouts.app')

@section('title', 'Resultado de importación - Lucky Inventario')

@section('styles')

<style>

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
    }

    .header h1 {
        font-size: 28px;
        margin: 0;
    }

    .header p {
        color: #6b7280;
        margin-top: 5px;
    }

    .resumen {
        display: grid;
        grid-template-columns:
            repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0,0,0,.06);
    }

    .card-title {
        color: #6b7280;
        font-size: 14px;
    }

    .card-value {
        font-size: 28px;
        font-weight: bold;
        margin-top: 8px;
    }

    .ok {
        color: #15803d;
    }

    .error {
        color: #dc2626;
    }

    .panel {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0,0,0,.06);
    }

    .panel-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 18px;
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
        font-size: 13px;
        color: #6b7280;
    }

    td {
        padding: 12px;
        border-top: 1px solid #eee;
    }

    .estado {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 12px;
    }

    .estado-ok {
        background: #dcfce7;
        color: #166534;
    }

    .estado-error {
        background: #fee2e2;
        color: #991b1b;
    }

    .acciones {
        margin-top: 20px;
        display: flex;
        gap: 10px;
    }

    .btn {
        display: inline-block;
        padding: 11px 18px;
        border-radius: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    @media(max-width:700px) {

        .container {
            padding: 15px;
        }

        .resumen {
            grid-template-columns: 1fr;
        }

        .acciones {
            flex-direction: column;
        }

        .btn {
            text-align: center;
        }
    }

</style>

@endsection


@section('content')

<div class="container">

    <div class="header">

        <div>

            <h1>Resultado de importación</h1>

            <p>
                Resultado del procesamiento del archivo Excel
            </p>

        </div>

    </div>


    {{-- RESUMEN --}}

    <div class="resumen">

        <div class="card">

            <div class="card-title">
                Filas procesadas
            </div>

            <div class="card-value">
                {{ $import->procesadas }}
            </div>

        </div>


        <div class="card">

            <div class="card-title">
                Importaciones exitosas
            </div>

            <div class="card-value ok">
                {{ $import->exitosas }}
            </div>

        </div>


        <div class="card">

            <div class="card-title">
                Errores
            </div>

            <div class="card-value error">
                {{ $import->errores }}
            </div>

        </div>

    </div>


    {{-- DETALLE --}}

    <div class="panel">

        <div class="panel-title">
            Detalle de importación
        </div>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Fila</th>

                        <th>Código</th>

                        <th>Estado</th>

                        <th>Cantidad</th>

                        <th>Mensaje</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($import->resultado as $item)

                        <tr>

                            <td>
                                {{ $item['fila'] }}
                            </td>

                            <td>
                                {{ $item['codigo'] ?? '-' }}
                            </td>

                            <td>

                                @if($item['estado'] === 'OK')

                                    <span
                                        class="estado estado-ok">

                                        OK

                                    </span>

                                @else

                                    <span
                                        class="estado estado-error">

                                        ERROR

                                    </span>

                                @endif

                            </td>

                            <td>

                                @isset($item['cantidad'])

                                    {{ number_format(
                                        $item['cantidad'],
                                        3
                                    ) }}

                                @else

                                    -

                                @endisset

                            </td>

                            <td>
                                {{ $item['mensaje'] }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                style="text-align:center;padding:30px;">

                                No se procesaron registros.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="acciones">

            <a
                href="{{ route('entradas.importar') }}"
                class="btn btn-primary">

                Nueva importación

            </a>


            <a
                href="{{ route('entradas.importar.plantilla') }}"
                class="btn btn-secondary">

                Descargar plantilla

            </a>

        </div>

    </div>

</div>

@endsection
@extends('layouts.app')

@section('title', 'Entradas')

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

        .panel {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        }

        .filters {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto auto;
            gap: 10px;
            margin-bottom: 20px;
        }

        input,
        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
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

        .cantidad {
            font-weight: bold;
            color: #166534;
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

        @media(max-width: 900px) {

            .filters {
                grid-template-columns: 1fr;
            }

        }

        @media(max-width: 700px) {

            .container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

        }

        .btn-excel {
            background: #16a34a;
            color: white;
        }

        .btn-excel:hover {
            background: #15803d;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        @media(max-width: 700px) {

            .container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .header-actions .btn {
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

                <h1>Entradas de Stock</h1>

                <p>
                    Registro de ingresos de productos al inventario
                </p>

            </div>

            <div class="header-actions">

                {{-- Registrar una entrada manual --}}
                <a
                    href="{{ route('entradas.create') }}"
                    class="btn btn-primary">
                    + Registrar entrada
                </a>

                {{-- Importar productos y stock desde Excel --}}
                <a
                    href="{{ route('entradas.importar') }}"
                    class="btn btn-excel"
                >
                    📊 Importar Excel
                </a>

            </div>

        </div>


        {{-- MENSAJE --}}

        @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif


        {{-- ERRORES --}}

        @if($errors->any())

        <div class="alert alert-success">

            <ul>

                @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif


        <div class="panel">


            {{-- FILTROS --}}

            <form
                method="GET"
                action="{{ route('entradas.index') }}"
                class="filters">

                <select name="producto_id">

                    <option value="">
                        Todos los productos
                    </option>

                    @foreach($productos as $producto)

                    <option
                        value="{{ $producto->id }}"
                        {{ request('producto_id') == $producto->id ? 'selected' : '' }}>
                        {{ $producto->codigo }}
                        -
                        {{ $producto->descripcion }}
                    </option>

                    @endforeach

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
                    href="{{ route('entradas.index') }}"
                    class="btn btn-secondary">
                    Limpiar
                </a>

            </form>


            {{-- TABLA --}}

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Fecha</th>

                            <th>Código</th>

                            <th>Descripción</th>

                            <th>Espesor</th>

                            <th>Cantidad</th>

                            <th>Observación</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($entradas as $entrada)

                        <tr>

                            <td>
                                #{{ $entrada->id }}
                            </td>

                            <td>
                                {{ $entrada->fecha->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                <strong>
                                    {{ $entrada->producto->codigo }}
                                </strong>
                            </td>

                            <td>
                                {{ $entrada->producto->descripcion }}
                            </td>

                            <td>
                                {{ number_format(
                                    $entrada->producto->espesor,
                                    3
                                ) }}
                            </td>

                            <td class="cantidad">

                                +
                                {{ number_format(
                                    $entrada->cantidad,
                                    3
                                ) }}

                            </td>

                            <td>
                                {{ $entrada->observacion ?? '-' }}
                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'entradas.show',
                                        $entrada
                                    ) }}"
                                    class="btn btn-secondary">
                                    Ver
                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8">

                                No se encontraron entradas.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINACIÓN --}}

            <div class="pagination">

                {{ $entradas->links() }}

            </div>

        </div>

    </div>

@endsection
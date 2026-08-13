@extends('layouts.app')

@section('title', 'Productos')

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

        .btn-danger {
            background: #dc2626;
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
            box-shadow: 0 3px 10px rgba(0,0,0,.06);
        }

        .search {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search input {
            flex: 1;
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

        .activo {
            background: #dcfce7;
            color: #166534;
        }

        .inactivo {
            background: #fee2e2;
            color: #991b1b;
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

        @media(max-width:700px) {

            .container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .search {
                flex-direction: column;
            }

            .acciones {
                flex-direction: column;
            }

        }

    </style>

@endsection


@section('content')

<div class="container">

    <div class="header">

        <div>

            <h1>Productos</h1>

            <p>
                Gestión de productos del inventario
            </p>

        </div>

        <div>

            <a
                href="{{ route('productos.create') }}"
                class="btn btn-primary"
            >
                + Nuevo producto
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

        {{-- BUSCADOR --}}

        <form
            method="GET"
            action="{{ route('productos.index') }}"
            class="search"
        >

            <input
                type="text"
                name="buscar"
                placeholder="Buscar por código o descripción..."
                value="{{ request('buscar') }}"
            >

            <button
                type="submit"
                class="btn btn-primary"
            >
                Buscar
            </button>

            <a
                href="{{ route('productos.index') }}"
                class="btn btn-secondary"
            >
                Limpiar
            </a>

        </form>


        {{-- TABLA --}}

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

                        <th>
                            Stock
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

                    @forelse($productos as $producto)

                        <tr>

                            <td>
                                <strong>
                                    {{ $producto->codigo }}
                                </strong>
                            </td>

                            <td>
                                {{ $producto->descripcion }}
                            </td>

                            <td>
                                {{ number_format($producto->espesor, 3) }}
                            </td>

                            <td>
                                {{ number_format($producto->stock_actual, 3) }}
                            </td>

                            <td>

                                @if($producto->estado)

                                    <span class="estado activo">
                                        Activo
                                    </span>

                                @else

                                    <span class="estado inactivo">
                                        Inactivo
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="acciones">

                                    <a
                                        href="{{ route(
                                            'productos.show',
                                            $producto
                                        ) }}"
                                        class="btn btn-secondary"
                                    >
                                        Ver
                                    </a>

                                    <a
                                        href="{{ route(
                                            'productos.edit',
                                            $producto
                                        ) }}"
                                        class="btn btn-warning"
                                    >
                                        Editar
                                    </a>

                                    @if($producto->estado)

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'productos.destroy',
                                                $producto
                                            ) }}"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger"
                                                onclick="return confirm(
                                                    '¿Deseas desactivar este producto?'
                                                )"
                                            >
                                                Desactivar
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                No se encontraron productos.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}

        <div class="pagination">

            {{ $productos->links() }}

        </div>

    </div>

</div>

@endsection
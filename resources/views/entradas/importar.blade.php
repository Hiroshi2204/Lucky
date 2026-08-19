@extends('layouts.app')

@section('title', 'Importar productos - Lucky Inventario')

@section('styles')

<style>

    .container {
        max-width: 1000px;
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

    .panel {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0,0,0,.06);
        margin-bottom: 20px;
    }

    .panel-title {
        font-size: 19px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    .info {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }

    input[type="file"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
    }

    .acciones {
        display: flex;
        gap: 10px;
        justify-content: space-between;
        align-items: center;
    }

    .acciones-derecha {
        display: flex;
        gap: 10px;
    }

    .btn {
        display: inline-block;
        padding: 11px 18px;
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

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-success {
        background: #16a34a;
        color: white;
    }

    .btn-success:hover {
        background: #15803d;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .formato {
        margin-top: 20px;
    }

    .formato table {
        width: 100%;
        border-collapse: collapse;
    }

    .formato th {
        background: #f9fafb;
        text-align: left;
        padding: 12px;
        color: #6b7280;
        font-size: 13px;
    }

    .formato td {
        padding: 12px;
        border-top: 1px solid #eee;
    }

    .obligatorio {
        color: #dc2626;
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

        .acciones {
            flex-direction: column;
            align-items: stretch;
        }

        .acciones-derecha {
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

            <h1>Importar productos</h1>

            <p>
                Registrar productos y entradas de stock mediante Excel
            </p>

        </div>

    </div>


    <div class="panel">

        <div class="panel-title">
            Importación de productos y stock
        </div>


        <div class="info">

            <strong>¿Cómo funciona?</strong>

            <br>

            Seleccione un archivo Excel con los productos que desea
            importar.

            <br>

            Si el producto no existe, será creado automáticamente.

            <br>

            Si el producto ya existe, se agregará la cantidad indicada
            como una nueva entrada de stock.

        </div>


        <form
            action="{{ route('entradas.importar.procesar') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            <div class="form-group">

                <label>
                    Archivo Excel
                    <span class="obligatorio">*</span>
                </label>

                <input
                    type="file"
                    name="archivo"
                    accept=".xlsx,.xls,.csv"
                    required>

            </div>


            @if($errors->any())

                <div
                    style="
                        background:#fee2e2;
                        color:#991b1b;
                        padding:15px;
                        border-radius:8px;
                        margin-bottom:20px;
                    ">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <div class="acciones">

                <a
                    href="{{ route('ventas.index') }}"
                    class="btn btn-secondary">

                    Cancelar

                </a>


                <div class="acciones-derecha">

                    <a
                        href="{{ route('entradas.importar.plantilla') }}"
                        class="btn btn-success">

                        Descargar plantilla

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        Importar Excel

                    </button>

                </div>

            </div>

        </form>

    </div>


    <div class="panel formato">

        <div class="panel-title">
            Formato del archivo
        </div>


        <table>

            <thead>

                <tr>

                    <th>Columna</th>

                    <th>Descripción</th>

                    <th>Ejemplo</th>

                </tr>

            </thead>


            <tbody>

                <tr>

                    <td>
                        <strong>codigo</strong>
                    </td>

                    <td>
                        Código único del producto
                    </td>

                    <td>
                        P001
                    </td>

                </tr>


                <tr>

                    <td>
                        <strong>descripcion</strong>
                    </td>

                    <td>
                        Descripción del producto
                    </td>

                    <td>
                        Producto ejemplo
                    </td>

                </tr>


                <tr>

                    <td>
                        <strong>espesor</strong>
                    </td>

                    <td>
                        Espesor del producto
                    </td>

                    <td>
                        0.300
                    </td>

                </tr>


                <tr>

                    <td>
                        <strong>cantidad</strong>
                    </td>

                    <td>
                        Cantidad que ingresará al inventario
                    </td>

                    <td>
                        100
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection
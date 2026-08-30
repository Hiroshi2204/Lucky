@extends('layouts.app')

@section('title', 'Nuevo producto')


@section('styles')

<style>

    .container {
        max-width: 900px;
        margin: auto;
        padding: 25px;
    }

    .header {
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
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 7px;
        font-size: 14px;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        padding: 11px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, .10);
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .help {
        display: block;
        margin-top: 5px;
        color: #6b7280;
        font-size: 12px;
    }

    .alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert-info {
        background: #eff6ff;
        color: #1e40af;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        line-height: 1.5;
    }

    .error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 5px;
    }

    .acciones {
        display: flex;
        justify-content: space-between;
        margin-top: 25px;
        gap: 10px;
    }

    .btn {
        display: inline-block;
        padding: 11px 18px;
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

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    @media(max-width:700px) {

        .container {
            padding: 15px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
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

    {{-- CABECERA --}}

    <div class="header">

        <h1>
            Nuevo producto
        </h1>

        <p>
            Registrar un nuevo producto en el inventario
        </p>

    </div>


    {{-- ERRORES GENERALES --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                No se pudo registrar el producto:
            </strong>

            <ul style="margin-top:8px; margin-left:20px;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORMULARIO --}}

    <div class="panel">

        <form
            method="POST"
            action="{{ route('productos.store') }}"
        >

            @csrf


            <div class="form-grid">


                {{-- CÓDIGO --}}

                <div class="form-group">

                    <label for="codigo">

                        Código

                        <span class="required">
                            *
                        </span>

                    </label>

                    <input
                        type="text"
                        id="codigo"
                        name="codigo"
                        class="form-control"
                        value="{{ old('codigo') }}"
                        maxlength="100"
                        placeholder="Ejemplo: PROD-001"
                        required
                        autofocus
                    >

                    <span class="help">
                        Código único del producto.
                    </span>

                    @error('codigo')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ESPESOR --}}

                <div class="form-group">

                    <label for="espesor">

                        Espesor

                        <span class="required">
                            *
                        </span>

                    </label>

                    <input
                        type="number"
                        id="espesor"
                        name="espesor"
                        class="form-control"
                        value="{{ old('espesor') }}"
                        min="0"
                        step="0.001"
                        placeholder="Ejemplo: 1.500"
                        required
                    >

                    <span class="help">
                        Valor numérico del espesor.
                    </span>

                    @error('espesor')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- DESCRIPCIÓN --}}

                <div class="form-group full">

                    <label for="descripcion">

                        Descripción

                        <span class="required">
                            *
                        </span>

                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        class="form-control"
                        maxlength="255"
                        placeholder="Ingrese la descripción del producto"
                        required
                    >{{ old('descripcion') }}</textarea>

                    @error('descripcion')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            {{-- INFORMACIÓN --}}

            <div class="alert-info">

                <strong>
                    Información importante
                </strong>

                <br>

                El producto se registrará como
                <strong>activo</strong>
                y tendrá un stock inicial de
                <strong>0</strong>.

                <br><br>

                El stock deberá ingresarse posteriormente mediante
                el módulo de
                <strong>Entradas de Stock</strong>.

            </div>


            {{-- BOTONES --}}

            <div class="acciones">

                <a
                    href="{{ route('productos.index') }}"
                    class="btn btn-secondary"
                >
                    ← Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Guardar producto
                </button>

            </div>


        </form>

    </div>

</div>

@endsection
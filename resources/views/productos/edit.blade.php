<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar producto</title>

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
            max-width: 900px;
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

        .panel {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,.06);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .required {
            color: #dc2626;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37,99,235,.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .help {
            display: block;
            margin-top: 5px;
            color: #6b7280;
            font-size: 12px;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .stock {
            margin-top: 10px;
            padding: 20px;
            border-radius: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .stock-title {
            color: #6b7280;
            font-size: 13px;
        }

        .stock-value {
            font-size: 32px;
            font-weight: bold;
            margin-top: 5px;
            color: #111827;
        }

        .acciones {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
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

        .btn-info {
            background: #0891b2;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-info:hover {
            background: #0e7490;
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

            .row {
                grid-template-columns: 1fr;
                gap: 0;
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

    <div class="header">

        <div>

            <h1>Editar producto</h1>

            <p>
                Modificar información del producto
            </p>

        </div>

        <a
            href="{{ route('productos.index') }}"
            class="btn btn-secondary"
        >
            ← Volver
        </a>

    </div>


    {{-- ERRORES --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                No se pudo actualizar el producto.
            </strong>

            <ul style="margin-top: 8px; padding-left: 20px;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="panel">

        <form
            method="POST"
            action="{{ route('productos.update', $producto) }}"
        >

            @csrf

            @method('PUT')


            <div class="row">

                {{-- CÓDIGO --}}

                <div class="form-group">

                    <label for="codigo">

                        Código
                        <span class="required">*</span>

                    </label>

                    <input
                        type="text"
                        id="codigo"
                        name="codigo"
                        class="form-control"
                        value="{{ old(
                            'codigo',
                            $producto->codigo
                        ) }}"
                        maxlength="100"
                        required
                    >

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
                        <span class="required">*</span>

                    </label>

                    <input
                        type="number"
                        id="espesor"
                        name="espesor"
                        class="form-control"
                        value="{{ old(
                            'espesor',
                            $producto->espesor
                        ) }}"
                        min="0"
                        step="0.001"
                        required
                    >

                    @error('espesor')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            {{-- DESCRIPCIÓN --}}

            <div class="form-group">

                <label for="descripcion">

                    Descripción
                    <span class="required">*</span>

                </label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                    class="form-control"
                    maxlength="255"
                    required
                >{{ old(
                    'descripcion',
                    $producto->descripcion
                ) }}</textarea>

                @error('descripcion')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- STOCK --}}

            <div class="stock">

                <div class="stock-title">
                    STOCK ACTUAL
                </div>

                <div class="stock-value">

                    {{ number_format(
                        $producto->stock_actual,
                        3
                    ) }}

                </div>

                <small>
                    El stock no se modifica desde la edición
                    del producto.
                </small>

            </div>


            <br>


            {{-- INFORMACIÓN --}}

            <div class="alert alert-info">

                <strong>Control de inventario</strong>

                <br>

                Para modificar el stock utiliza los módulos
                de <strong>Entradas</strong> y
                <strong>Ventas</strong>.

            </div>


            {{-- BOTONES --}}

            <div class="acciones">

                <a
                    href="{{ route(
                        'productos.show',
                        $producto
                    ) }}"
                    class="btn btn-info"
                >
                    Ver producto
                </a>

                <a
                    href="{{ route('productos.index') }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>
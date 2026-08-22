@extends('layouts.app')

@section('title', 'Nueva entrada - Lucky Inventario')


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
        max-width: 900px;
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

    label {
        font-weight: bold;
        margin-bottom: 7px;
        font-size: 14px;
    }

    input,
    textarea {
        padding: 11px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        width: 100%;
    }

    input:read-only {
        background: #f3f4f6;
        color: #6b7280;
    }

    textarea {
        min-height: 100px;
        resize: vertical;
    }

    .stock-box {
        margin-top: 20px;
        padding: 15px;
        background: #eff6ff;
        border-radius: 8px;
        color: #1e40af;
    }

    .nuevo-box {
        margin-top: 20px;
        padding: 15px;
        background: #ecfdf5;
        border-radius: 8px;
        color: #166534;
    }

    .error-box {
        margin-bottom: 20px;
        padding: 15px;
        background: #fee2e2;
        border-radius: 8px;
        color: #991b1b;
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

    .autocomplete {
        position: relative;
    }

    .lista-productos {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .10);
        z-index: 1000;
        display: none;
        max-height: 250px;
        overflow-y: auto;
    }

    .producto-opcion {
        padding: 12px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
    }

    .producto-opcion:hover {
        background: #f3f4f6;
    }

    .producto-codigo {
        font-weight: bold;
        color: #1f2937;
    }

    .producto-descripcion {
        font-size: 13px;
        color: #6b7280;
        margin-top: 3px;
    }

    .producto-stock {
        font-size: 12px;
        color: #166534;
        margin-top: 3px;
    }
</style>

@endsection



@section('content')
<div class="container">

    <div class="header">

        <h1>Nueva entrada de stock</h1>

        <p>
            Registrar ingreso de productos al inventario
        </p>

    </div>


    {{-- ERRORES --}}

    @if($errors->any())

    <div class="error-box">

        <strong>
            No se pudo registrar la entrada:
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


    <div class="panel">

        <form
            method="POST"
            action="{{ route('entradas.store') }}">

            @csrf

            <div class="form-grid">

                {{-- CODIGO --}}

                <div class="form-group">

                    <label>
                        Código
                    </label>

                    <div class="autocomplete">

                        <input
                            type="text"
                            name="codigo"
                            id="codigo"
                            value="{{ old('codigo') }}"
                            required
                            autocomplete="off"
                            placeholder="Escriba el código del producto...">

                        <div
                            id="listaProductos"
                            class="lista-productos"></div>

                    </div>

                    <small
                        id="codigoMensaje"
                        style="margin-top:6px;"></small>

                </div>


                {{-- CANTIDAD --}}

                <div class="form-group">

                    <label>
                        Cantidad
                    </label>

                    <input
                        type="number"
                        name="cantidad"
                        step="0.001"
                        min="0.001"
                        value="{{ old('cantidad') }}"
                        required>

                </div>


                {{-- DESCRIPCION --}}

                <div class="form-group">

                    <label>
                        Descripción
                    </label>

                    <input
                        type="text"
                        name="descripcion"
                        id="descripcion"
                        value="{{ old('descripcion') }}"
                        required
                        readonly>

                </div>


                {{-- ESPESOR --}}

                <div class="form-group">

                    <label>
                        Espesor
                    </label>

                    <input
                        type="number"
                        name="espesor"
                        id="espesor"
                        step="0.01"
                        min="0"
                        value="{{ old('espesor') }}"
                        required
                        readonly>

                </div>


                {{-- OBSERVACION --}}

                <div class="form-group full">

                    <label>
                        Observación
                    </label>

                    <textarea
                        name="observacion"
                        placeholder="Observación opcional...">{{ old('observacion') }}</textarea>

                </div>

            </div>


            {{-- STOCK --}}

            <div
                id="stockBox"
                class="stock-box"
                style="display:none;">

                <strong>
                    Stock actual:
                </strong>

                <span id="stockActual">
                    0.000
                </span>

            </div>


            {{-- PRODUCTO NUEVO --}}

            <div
                id="nuevoBox"
                class="nuevo-box"
                style="display:none;">

                <strong>
                    Producto nuevo
                </strong>

                <br>

                Complete la descripción y el espesor
                para registrarlo.

            </div>


            <div class="acciones">

                <a
                    href="{{ route('entradas.index') }}"
                    class="btn btn-secondary">
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary">
                    Registrar entrada
                </button>

            </div>

        </form>

    </div>

</div>

@endsection



@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        console.log('CREATE ENTRADAS: JavaScript cargado');

        const codigoInput =
            document.getElementById('codigo');

        const descripcionInput =
            document.getElementById('descripcion');

        const espesorInput =
            document.getElementById('espesor');

        const stockBox =
            document.getElementById('stockBox');

        const stockActual =
            document.getElementById('stockActual');

        const nuevoBox =
            document.getElementById('nuevoBox');

        const codigoMensaje =
            document.getElementById('codigoMensaje');

        const listaProductos =
            document.getElementById('listaProductos');

        const cantidadInput =
            document.querySelector('input[name="cantidad"]');


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR ELEMENTOS
        |--------------------------------------------------------------------------
        */

        if (!codigoInput) {
            console.error('No existe #codigo');
            return;
        }

        if (!descripcionInput) {
            console.error('No existe #descripcion');
            return;
        }

        if (!espesorInput) {
            console.error('No existe #espesor');
            return;
        }

        if (!listaProductos) {
            console.error('No existe #listaProductos');
            return;
        }


        console.log('Elementos encontrados correctamente');


        let timeoutBusqueda = null;


        /*
        |--------------------------------------------------------------------------
        | ESCRIBIR CÓDIGO
        |--------------------------------------------------------------------------
        */

        codigoInput.addEventListener('input', function() {

            const codigo =
                this.value.trim().toUpperCase();

            this.value = codigo;

            clearTimeout(timeoutBusqueda);


            /*
            |--------------------------------------------------------------------------
            | CAMPO VACÍO
            |--------------------------------------------------------------------------
            */

            if (codigo.length === 0) {

                listaProductos.innerHTML = '';

                listaProductos.style.display = 'none';

                codigoMensaje.textContent = '';

                descripcionInput.value = '';

                espesorInput.value = '';

                descripcionInput.readOnly = false;

                espesorInput.readOnly = false;

                stockBox.style.display = 'none';

                nuevoBox.style.display = 'none';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | ESPERAR 300ms
            |--------------------------------------------------------------------------
            */

            codigoMensaje.textContent =
                'Buscando producto...';

            codigoMensaje.style.color =
                '#6b7280';


            timeoutBusqueda = setTimeout(function() {

                buscarProductos(codigo);

            }, 300);

        });


        /*
        |--------------------------------------------------------------------------
        | BUSCAR PRODUCTOS
        |--------------------------------------------------------------------------
        */

        async function buscarProductos(codigo) {

            console.log(
                'Buscando producto:',
                codigo
            );


            /*
            |--------------------------------------------------------------------------
            | URL DEL API
            |--------------------------------------------------------------------------
            */

            const url =
                "{{ route('api.productos.buscar') }}" +
                "?codigo=" +
                encodeURIComponent(codigo);


            console.log(
                'URL API:',
                url
            );


            try {

                const response =
                    await fetch(url, {

                        method: 'GET',

                        headers: {
                            'Accept': 'application/json'
                        }

                    });


                console.log(
                    'HTTP:',
                    response.status
                );


                if (!response.ok) {

                    throw new Error(
                        'HTTP ' + response.status
                    );

                }


                const resultado =
                    await response.json();


                console.log(
                    'Respuesta API:',
                    resultado
                );


                /*
                |--------------------------------------------------------------------------
                | OBTENER PRODUCTOS
                |--------------------------------------------------------------------------
                */

                let productos;


                if (Array.isArray(resultado)) {

                    productos = resultado;

                } else if (
                    Array.isArray(resultado.data)
                ) {

                    productos = resultado.data;

                } else if (
                    resultado.data
                ) {

                    productos = [
                        resultado.data
                    ];

                } else {

                    productos = [];

                }


                console.log(
                    'Productos encontrados:',
                    productos
                );


                /*
                |--------------------------------------------------------------------------
                | NO EXISTE
                |--------------------------------------------------------------------------
                */

                if (productos.length === 0) {

                    mostrarProductoNuevo();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | MOSTRAR RESULTADOS
                |--------------------------------------------------------------------------
                */

                listaProductos.innerHTML = '';


                productos.forEach(function(producto) {

                    const opcion =
                        document.createElement('div');


                    opcion.className =
                        'producto-opcion';


                    opcion.innerHTML = `

                    <div class="producto-codigo">
                        ${producto.codigo ?? ''}
                    </div>

                    <div class="producto-descripcion">
                        ${producto.descripcion ?? ''}
                    </div>

                    <div class="producto-stock">
                        Stock:
                        ${Number(
                            producto.stock_actual ?? 0
                        ).toFixed(3)}
                    </div>

                `;


                    opcion.addEventListener(
                        'click',
                        function() {

                            seleccionarProducto(
                                producto
                            );

                        }
                    );


                    listaProductos.appendChild(
                        opcion
                    );

                });


                listaProductos.style.display =
                    'block';


                codigoMensaje.textContent =
                    'Seleccione un producto de la lista.';

                codigoMensaje.style.color =
                    '#1e40af';

            } catch (error) {

                console.error(
                    'ERROR BUSCANDO PRODUCTO:',
                    error
                );


                listaProductos.innerHTML = '';


                listaProductos.style.display =
                    'none';


                codigoMensaje.textContent =
                    'Error al buscar el producto.';

                codigoMensaje.style.color =
                    '#dc2626';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | SELECCIONAR PRODUCTO
        |--------------------------------------------------------------------------
        */

        function seleccionarProducto(producto) {

            console.log(
                'Producto seleccionado:',
                producto
            );


            codigoInput.value =
                producto.codigo ?? '';


            descripcionInput.value =
                producto.descripcion ?? '';


            espesorInput.value =
                producto.espesor ?? '';


            descripcionInput.readOnly =
                true;

            espesorInput.readOnly =
                true;


            /*
            |--------------------------------------------------------------------------
            | STOCK
            |--------------------------------------------------------------------------
            */

            stockActual.textContent =
                Number(
                    producto.stock_actual ?? 0
                ).toFixed(3);


            stockBox.style.display =
                'block';


            /*
            |--------------------------------------------------------------------------
            | OCULTAR NUEVO
            |--------------------------------------------------------------------------
            */

            nuevoBox.style.display =
                'none';


            /*
            |--------------------------------------------------------------------------
            | OCULTAR LISTA
            |--------------------------------------------------------------------------
            */

            listaProductos.innerHTML =
                '';

            listaProductos.style.display =
                'none';


            /*
            |--------------------------------------------------------------------------
            | MENSAJE
            |--------------------------------------------------------------------------
            */

            codigoMensaje.textContent =
                'Producto seleccionado. Solo ingrese la cantidad.';

            codigoMensaje.style.color =
                '#166534';


            /*
            |--------------------------------------------------------------------------
            | ENFOCAR CANTIDAD
            |--------------------------------------------------------------------------
            */

            if (cantidadInput) {

                cantidadInput.focus();

            }

        }


        /*
        |--------------------------------------------------------------------------
        | PRODUCTO NUEVO
        |--------------------------------------------------------------------------
        */

        function mostrarProductoNuevo() {

            console.log(
                'Producto nuevo'
            );


            listaProductos.innerHTML =
                '';

            listaProductos.style.display =
                'none';


            descripcionInput.value =
                '';


            espesorInput.value =
                '';


            descripcionInput.readOnly =
                false;

            espesorInput.readOnly =
                false;


            stockBox.style.display =
                'none';


            nuevoBox.style.display =
                'block';


            codigoMensaje.textContent =
                'No existe. Puede registrar un producto nuevo.';

            codigoMensaje.style.color =
                '#1e40af';

        }


        /*
        |--------------------------------------------------------------------------
        | CERRAR LISTA AL HACER CLICK AFUERA
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function(event) {

                if (
                    !event.target.closest(
                        '.autocomplete'
                    )
                ) {

                    listaProductos.style.display =
                        'none';

                }

            }
        );


    });
</script>

@endsection
@extends('layouts.app')

@section('title', 'Nueva venta - Lucky Inventario')


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
        padding: 22px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        margin-bottom: 20px;
    }

    .panel-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    .search-container {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 13px 15px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
    }

    .search-input:focus {
        border-color: #2563eb;
    }

    .sugerencias {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + 4px);
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .12);
        z-index: 100;
        max-height: 300px;
        overflow-y: auto;
        display: none;
    }

    .sugerencia {
        padding: 13px 15px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    .sugerencia:last-child {
        border-bottom: none;
    }

    .sugerencia:hover {
        background: #f3f4f6;
    }

    .sugerencia-codigo {
        font-weight: bold;
        color: #2563eb;
    }

    .sugerencia-descripcion {
        margin-top: 3px;
        color: #374151;
    }

    .sugerencia-stock {
        margin-top: 4px;
        font-size: 13px;
        color: #6b7280;
    }

    .sin-resultados {
        padding: 15px;
        color: #6b7280;
        text-align: center;
    }

    .tabla-container {
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
        white-space: nowrap;
    }

    td {
        padding: 10px;
        border-top: 1px solid #eee;
        vertical-align: middle;
    }

    .producto-codigo {
        font-weight: bold;
        color: #2563eb;
    }

    .producto-descripcion {
        font-size: 13px;
        color: #6b7280;
        margin-top: 3px;
    }

    .stock {
        font-weight: bold;
    }

    .input-tabla {
        width: 110px;
        padding: 9px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        text-align: right;
    }

    .subtotal {
        font-weight: bold;
        white-space: nowrap;
    }

    .btn-eliminar {
        background: #dc2626;
        color: white;
        border: none;
        padding: 8px 11px;
        border-radius: 7px;
        cursor: pointer;
    }

    .btn-eliminar:hover {
        background: #b91c1c;
    }

    .vacio {
        text-align: center;
        padding: 30px !important;
        color: #6b7280;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
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
    select,
    textarea {
        width: 100%;
        padding: 11px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background: white;
    }

    textarea {
        min-height: 90px;
        resize: vertical;
    }

    .medio-otro {
        display: none;
    }

    .resumen {
        background: #f9fafb;
        border-radius: 10px;
        padding: 18px;
        margin-top: 20px;
    }

    .resumen-row {
        display: flex;
        justify-content: space-between;
        padding: 7px 0;
    }

    .resumen-total {
        border-top: 1px solid #d1d5db;
        margin-top: 8px;
        padding-top: 15px;
        font-size: 22px;
        font-weight: bold;
    }

    .saldo {
        color: #dc2626;
        font-weight: bold;
    }

    .pagado {
        color: #166534;
        font-weight: bold;
    }

    .alert {
        padding: 13px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .acciones {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 20px;
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

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-primary:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    .cantidad-error {
        border-color: #dc2626 !important;
    }

    .stock-insuficiente {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
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

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .panel {
            padding: 15px;
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

            <h1>Nueva venta</h1>

            <p>
                Registrar salida de productos del inventario
            </p>

        </div>

    </div>


    {{-- ALERTAS --}}

    <div
        id="alertError"
        class="alert alert-error"></div>

    <div
        id="alertSuccess"
        class="alert alert-success"></div>


    {{-- BUSCADOR --}}

    <div class="panel">

        <div class="panel-title">
            Buscar producto
        </div>

        <div class="search-container">

            <input
                type="text"
                id="buscarProducto"
                class="search-input"
                placeholder="Escriba código o descripción..."
                autocomplete="off">

            <div
                id="sugerencias"
                class="sugerencias"></div>

        </div>

    </div>


    {{-- PRODUCTOS DE LA VENTA --}}

    <div class="panel">

        <div class="panel-title">
            Productos de la venta
        </div>

        <div class="tabla-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            Producto
                        </th>

                        <th>
                            Espesor
                        </th>

                        <th>
                            Stock
                        </th>

                        <th>
                            Cantidad
                        </th>

                        <th>
                            Precio unit.
                        </th>

                        <th>
                            Subtotal
                        </th>

                        <th>
                            Acción
                        </th>

                    </tr>

                </thead>

                <tbody id="detalleVenta">

                    <tr id="filaVacia">

                        <td
                            colspan="7"
                            class="vacio">
                            No hay productos agregados a la venta.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- DATOS DE PAGO --}}

    <div class="panel">

        <div class="panel-title">
            Información de pago
        </div>

        <div class="form-grid">

            {{-- MEDIO DE PAGO --}}

            <div class="form-group">

                <label>
                    Medio de pago
                </label>

                <select id="medioPago">

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


            {{-- OTRO MEDIO --}}

            <div
                class="form-group medio-otro"
                id="medioOtroContainer">

                <label>
                    Especifique el medio de pago
                </label>

                <input
                    type="text"
                    id="medioPagoOtro"
                    maxlength="100">

            </div>


            {{-- ESTADO PAGO --}}

            <div class="form-group">

                <label>
                    Estado de pago
                </label>

                <select id="estadoPago">

                    <option value="CANCELADO">
                        Cancelado
                    </option>

                    <option value="PENDIENTE">
                        Pendiente
                    </option>

                    <option value="PARCIAL">
                        Parcial
                    </option>

                    <!-- <option value="OTRO">
                            Otro
                        </option> -->

                </select>

            </div>


            {{-- MONTO PAGADO --}}

            <div class="form-group">

                <label>
                    Monto pagado
                </label>

                <input
                    type="number"
                    id="montoPagado"
                    min="0"
                    step="0.01"
                    value="0">

            </div>


            {{-- OBSERVACION --}}

            <div class="form-group full">

                <label>
                    Observación
                </label>

                <textarea
                    id="observacion"
                    placeholder="Observación opcional..."></textarea>

            </div>

        </div>


        {{-- RESUMEN --}}

        <div class="resumen">

            <div class="resumen-row">

                <span>
                    Total productos
                </span>

                <strong id="cantidadProductos">
                    0
                </strong>

            </div>


            <div class="resumen-row">

                <span>
                    Total
                </span>

                <strong id="totalVenta">
                    S/ 0.00
                </strong>

            </div>


            <div class="resumen-row">

                <span>
                    Monto pagado
                </span>

                <strong
                    id="resumenPagado"
                    class="pagado">
                    S/ 0.00
                </strong>

            </div>


            <div class="resumen-row">

                <span>
                    Saldo pendiente
                </span>

                <strong
                    id="saldoPendiente"
                    class="saldo">
                    S/ 0.00
                </strong>

            </div>


            <div class="resumen-row resumen-total">

                <span>
                    TOTAL
                </span>

                <span id="totalFinal">
                    S/ 0.00
                </span>

            </div>

        </div>


        {{-- BOTONES --}}

        <div class="acciones">

            <a
                href="{{ route('ventas.index') }}"
                class="btn btn-secondary">
                Cancelar
            </a>

            <button
                type="button"
                id="btnRegistrar"
                class="btn btn-primary">
                Registrar venta
            </button>

        </div>

    </div>

</div>
@endsection



@section('scripts')

<script>
    let productosVenta = [];


    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const buscarProducto =
        document.getElementById('buscarProducto');

    const sugerencias =
        document.getElementById('sugerencias');

    const detalleVenta =
        document.getElementById('detalleVenta');

    const medioPago =
        document.getElementById('medioPago');

    const medioOtroContainer =
        document.getElementById('medioOtroContainer');

    const medioPagoOtro =
        document.getElementById('medioPagoOtro');

    const estadoPago =
        document.getElementById('estadoPago');

    const montoPagado =
        document.getElementById('montoPagado');

    const btnRegistrar =
        document.getElementById('btnRegistrar');

    const alertError =
        document.getElementById('alertError');

    const alertSuccess =
        document.getElementById('alertSuccess');


    /*
    |--------------------------------------------------------------------------
    | FORMATEAR DINERO
    |--------------------------------------------------------------------------
    */

    function dinero(valor) {
        return Number(valor || 0)
            .toLocaleString('es-PE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR ERROR
    |--------------------------------------------------------------------------
    */

    function mostrarError(mensaje) {
        alertSuccess.style.display = 'none';

        alertError.textContent = mensaje;

        alertError.style.display = 'block';

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }


    /*
    |--------------------------------------------------------------------------
    | LIMPIAR ALERTAS
    |--------------------------------------------------------------------------
    */

    function limpiarAlertas() {
        alertError.style.display = 'none';
        alertSuccess.style.display = 'none';
    }


    /*
    |--------------------------------------------------------------------------
    | BUSCAR PRODUCTOS
    |--------------------------------------------------------------------------
    */

    let temporizadorBusqueda = null;

    buscarProducto.addEventListener(
        'input',
        function() {

            const buscar =
                this.value.trim();

            clearTimeout(
                temporizadorBusqueda
            );

            if (buscar.length < 1) {

                sugerencias.innerHTML = '';

                sugerencias.style.display =
                    'none';

                return;
            }


            temporizadorBusqueda =
                setTimeout(function() {

                    buscarProductos(buscar);

                }, 250);
        }
    );


    /*
    |--------------------------------------------------------------------------
    | CONSULTAR API
    |--------------------------------------------------------------------------
    */

    async function buscarProductos(buscar) {

        try {

            const url =
                `{{ route('productos.buscarVenta') }}?buscar=${encodeURIComponent(buscar)}`;

            console.log('Buscando:', url);

            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {

                throw new Error(
                    `Error HTTP ${response.status}`
                );

            }

            const resultado = await response.json();

            console.log('Resultado:', resultado);

            if (!resultado.success) {

                sugerencias.style.display = 'none';

                return;
            }

            mostrarSugerencias(
                resultado.data
            );

        } catch (error) {

            console.error(
                'Error buscando productos:',
                error
            );

            sugerencias.innerHTML = `
            <div class="sin-resultados">
                Error al buscar productos.
            </div>
        `;

            sugerencias.style.display = 'block';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR SUGERENCIAS
    |--------------------------------------------------------------------------
    */

    function mostrarSugerencias(productos) {
        sugerencias.innerHTML = '';


        if (!productos.length) {

            sugerencias.innerHTML = `
            <div class="sin-resultados">
                No se encontraron productos.
            </div>
        `;

            sugerencias.style.display =
                'block';

            return;
        }


        productos.forEach(function(producto) {

            const div =
                document.createElement('div');

            div.className =
                'sugerencia';


            div.innerHTML = `

            <div class="sugerencia-codigo">

                ${producto.codigo}

            </div>

            <div class="sugerencia-descripcion">

                ${producto.descripcion}

            </div>

            <div class="sugerencia-stock">

                Espesor:
                ${Number(producto.espesor).toFixed(2)}

                &nbsp; | &nbsp;

                Stock:
                ${Number(producto.stock_actual).toFixed(3)}

            </div>

        `;


            div.addEventListener(
                'click',
                function() {

                    agregarProducto(producto);

                }
            );


            sugerencias.appendChild(div);

        });


        sugerencias.style.display =
            'block';
    }


    /*
    |--------------------------------------------------------------------------
    | AGREGAR PRODUCTO
    |--------------------------------------------------------------------------
    */

    function agregarProducto(producto) {
        limpiarAlertas();


        /*
        |--------------------------------------------------------------------------
        | EVITAR PRODUCTO REPETIDO
        |--------------------------------------------------------------------------
        */

        const existe =
            productosVenta.some(
                item =>
                item.producto_id === producto.id
            );


        if (existe) {

            mostrarError(
                `El producto ${producto.codigo} ya está agregado a la venta.`
            );

            buscarProducto.value = '';

            sugerencias.style.display =
                'none';

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | STOCK CERO
        |--------------------------------------------------------------------------
        */

        if (
            Number(producto.stock_actual) <= 0
        ) {

            mostrarError(
                `El producto ${producto.codigo} no tiene stock disponible.`
            );

            return;
        }


        productosVenta.push({

            producto_id: producto.id,

            codigo: producto.codigo,

            descripcion: producto.descripcion,

            espesor: Number(producto.espesor),

            stock: Number(producto.stock_actual),

            cantidad: 1,

            precio_unitario: 0

        });


        buscarProducto.value = '';

        sugerencias.innerHTML = '';

        sugerencias.style.display =
            'none';


        renderizarProductos();

        calcularTotales();
    }

    function renderizarProductos() {
        detalleVenta.innerHTML = '';


        if (!productosVenta.length) {

            detalleVenta.innerHTML = `

            <tr>

                <td
                    colspan="7"
                    class="vacio"
                >
                    No hay productos agregados a la venta.
                </td>

            </tr>

        `;

            return;
        }


        productosVenta.forEach(
            function(item, index) {

                const subtotal =
                    item.cantidad *
                    item.precio_unitario;


                const tr =
                    document.createElement('tr');


                tr.innerHTML = `

                <td>

                    <div class="producto-codigo">

                        ${item.codigo}

                    </div>

                    <div class="producto-descripcion">

                        ${item.descripcion}

                    </div>

                </td>


                <td>

                    ${item.espesor.toFixed(2)}

                </td>


                <td>

                    <span class="stock">

                        ${item.stock.toFixed(3)}

                    </span>

                </td>


                <td>

                    <input
                        type="number"
                        class="input-tabla cantidad-input"
                        min="0.001"
                        max="${item.stock}"
                        step="0.001"
                        value="${item.cantidad}"
                        data-index="${index}"
                    >

                    <div
                        class="stock-insuficiente"
                        id="error-cantidad-${index}"
                    ></div>

                </td>


                <td>

                    <input
                        type="number"
                        class="input-tabla precio-input"
                        min="0"
                        step="0.01"
                        value="${item.precio_unitario}"
                        data-index="${index}"
                    >

                </td>


                <td>

                    <span class="subtotal">

                        S/ ${dinero(subtotal)}

                    </span>

                </td>


                <td>

                    <button
                        type="button"
                        class="btn-eliminar"
                        data-index="${index}"
                    >
                        Eliminar
                    </button>

                </td>

            `;


                detalleVenta.appendChild(tr);

            }
        );

        document
            .querySelectorAll('.cantidad-input')
            .forEach(function(input) {

                input.addEventListener(
                    'input',
                    function() {

                        const index =
                            Number(
                                this.dataset.index
                            );

                        let cantidad =
                            Number(this.value);


                        if (
                            cantidad <= 0 ||
                            isNaN(cantidad)
                        ) {

                            cantidad = 0;

                        }


                        productosVenta[index]
                            .cantidad = cantidad;


                        validarCantidad(index);

                        calcularTotales();

                    }
                );

            });

        document
            .querySelectorAll('.precio-input')
            .forEach(function(input) {

                input.addEventListener(
                    'input',
                    function() {

                        const index =
                            Number(
                                this.dataset.index
                            );

                        let precio =
                            Number(this.value);


                        if (
                            precio < 0 ||
                            isNaN(precio)
                        ) {

                            precio = 0;

                        }


                        productosVenta[index]
                            .precio_unitario =
                            precio;


                        calcularTotales();

                    }
                );

            });

        document
            .querySelectorAll('.btn-eliminar')
            .forEach(function(button) {

                button.addEventListener(
                    'click',
                    function() {

                        const index =
                            Number(
                                this.dataset.index
                            );

                        productosVenta.splice(
                            index,
                            1
                        );

                        renderizarProductos();

                        calcularTotales();

                    }
                );

            });
    }

    function validarCantidad(index) {
        const item =
            productosVenta[index];

        const input =
            document.querySelector(
                `.cantidad-input[data-index="${index}"]`
            );

        const error =
            document.getElementById(
                `error-cantidad-${index}`
            );


        if (
            item.cantidad >
            item.stock
        ) {

            input.classList.add(
                'cantidad-error'
            );

            error.textContent =
                `Máximo disponible: ${item.stock.toFixed(3)}`;

            return false;
        }


        input.classList.remove(
            'cantidad-error'
        );

        error.textContent = '';

        return true;
    }

    function calcularTotales() {
        let total = 0;

        productosVenta.forEach(
            function(item) {

                total +=
                    item.cantidad *
                    item.precio_unitario;

            }
        );


        const pagado =
            Number(montoPagado.value) || 0;


        const saldo =
            Math.max(
                total - pagado,
                0
            );


        document.getElementById(
                'cantidadProductos'
            ).textContent =
            productosVenta.length;


        document.getElementById(
                'totalVenta'
            ).textContent =
            `S/ ${dinero(total)}`;


        document.getElementById(
                'totalFinal'
            ).textContent =
            `S/ ${dinero(total)}`;


        document.getElementById(
                'resumenPagado'
            ).textContent =
            `S/ ${dinero(pagado)}`;


        document.getElementById(
                'saldoPendiente'
            ).textContent =
            `S/ ${dinero(saldo)}`;
    }

    medioPago.addEventListener(
        'change',
        function() {

            if (this.value === 'OTRO') {

                medioOtroContainer.style.display =
                    'flex';

            } else {

                medioOtroContainer.style.display =
                    'none';

                medioPagoOtro.value = '';

            }

        }
    );

    montoPagado.addEventListener(
        'input',
        function() {

            calcularTotales();

        }
    );

    document.addEventListener(
        'click',
        function(event) {

            if (
                !event.target.closest(
                    '.search-container'
                )
            ) {

                sugerencias.style.display =
                    'none';

            }

        }
    );
    btnRegistrar.addEventListener(
        'click',
        registrarVenta
    );


    async function registrarVenta() {
        limpiarAlertas();

        if (!productosVenta.length) {

            mostrarError(
                'Debe agregar al menos un producto a la venta.'
            );

            return;
        }

        for (
            let i = 0; i < productosVenta.length; i++
        ) {

            const item =
                productosVenta[i];


            if (
                item.cantidad <= 0
            ) {

                mostrarError(
                    `La cantidad de ${item.codigo} debe ser mayor que cero.`
                );

                return;
            }


            if (
                item.cantidad >
                item.stock
            ) {

                mostrarError(
                    `Stock insuficiente para ${item.codigo}.`
                );

                return;
            }


            if (
                item.precio_unitario < 0
            ) {

                mostrarError(
                    `El precio de ${item.codigo} no puede ser negativo.`
                );

                return;
            }

        }

        let total = 0;


        productosVenta.forEach(
            function(item) {

                total +=
                    item.cantidad *
                    item.precio_unitario;

            }
        );

        const pagado =
            Number(montoPagado.value) || 0;


        if (pagado < 0) {

            mostrarError(
                'El monto pagado no puede ser negativo.'
            );

            return;
        }


        if (pagado > total) {

            mostrarError(
                'El monto pagado no puede ser mayor al total.'
            );

            return;
        }

        const estado =
            estadoPago.value;


        if (
            estado === 'CANCELADO' &&
            pagado !== total
        ) {

            mostrarError(
                'Una venta cancelada debe tener el monto total pagado.'
            );

            return;
        }


        if (
            estado === 'PENDIENTE' &&
            pagado !== 0
        ) {

            mostrarError(
                'Una venta pendiente debe tener monto pagado igual a cero.'
            );

            return;
        }


        if (
            estado === 'PARCIAL' &&
            (
                pagado <= 0 ||
                pagado >= total
            )
        ) {

            mostrarError(
                'Una venta parcial debe tener un pago mayor que cero y menor que el total.'
            );

            return;
        }

        btnRegistrar.disabled =
            true;

        btnRegistrar.textContent =
            'Registrando...';

        const detalles =
            productosVenta.map(
                function(item) {

                    return {

                        producto_id: item.producto_id,

                        cantidad: item.cantidad,

                        precio_unitario: item.precio_unitario

                    };

                }
            );


        const datos = {

            medio_pago: medioPago.value,

            medio_pago_otro: medioPago.value === 'OTRO' ?
                medioPagoOtro.value : null,

            estado_pago: estadoPago.value,

            monto_pagado: pagado,

            observacion: document.getElementById(
                'observacion'
            ).value,

            detalles: detalles

        };


        try {

            const response =
                 await fetch("{{ route('ventas.store') }}", {

                    method: 'POST',

                    headers: {

                        'Content-Type': 'application/json',

                        'Accept': 'application/json',

                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')

                    },

                    body: JSON.stringify(datos)

                });


            const texto = await response.text();

            console.log('STATUS:', response.status);
            console.log('URL:', response.url);
            console.log('RESPUESTA DEL SERVIDOR:', texto);

            let resultado;

            try {

                resultado = JSON.parse(texto);

            } catch (e) {

                throw new Error(
                    `El servidor no devolvió JSON. HTTP ${response.status}. Revisa la consola.`
                );
            }


            if (!response.ok) {

                let mensaje =
                    resultado.message ||
                    'No se pudo registrar la venta.';

                if (resultado.errors) {

                    const errores =
                        Object.values(resultado.errors)
                        .flat();

                    mensaje = errores.join(' ');
                }

                throw new Error(mensaje);
            }

            alertSuccess.textContent =
                resultado.message ||
                'Venta registrada correctamente.';


            alertSuccess.style.display =
                'block';

            setTimeout(
                function() {

                    if (
                        resultado.data &&
                        resultado.data.id
                    ) {

                        window.location.href =
                            `{{ url('/ventas') }}/${resultado.data.id}`;

                    } else {

                        window.location.href =
                            `{{ route('ventas.index') }}`;

                    }

                },
                1000
            );


        } catch (error) {

            console.error(error);

            mostrarError(
                error.message ||
                'Ocurrió un error al registrar la venta.'
            );


            btnRegistrar.disabled =
                false;

            btnRegistrar.textContent =
                'Registrar venta';

        }
    }

    calcularTotales();
</script>
@endsection
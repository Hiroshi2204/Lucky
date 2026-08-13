<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Registrar pago</title>

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
            max-width: 750px;
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

        .resumen {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .card {
            padding: 18px;
            border-radius: 10px;
            background: #f9fafb;
        }

        .card span {
            display: block;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .card strong {
            font-size: 22px;
        }

        .total {
            color: #1d4ed8;
        }

        .saldo {
            color: #dc2626;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .info {
            padding: 15px;
            background: #eff6ff;
            color: #1e40af;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            padding: 15px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .acciones {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 11px 18px;
            border: none;
            border-radius: 8px;
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

        @media(max-width:600px) {

            .container {
                padding: 15px;
            }

            .resumen {
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

</head>

<body>

    <div class="container">

        <div class="header">

            <h1>
                Registrar pago
            </h1>

            <p>
                Venta #{{ $venta->id }}
            </p>

        </div>


        <div class="panel">

            {{-- ERRORES --}}

            @if($errors->any())

            <div class="error">

                <strong>
                    No se pudo registrar el pago:
                </strong>

                <ul style="margin-left:20px;margin-top:8px;">

                    @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                    @endforeach

                </ul>

            </div>

            @endif


            {{-- RESUMEN --}}

            <div class="resumen">

                <div class="card">

                    <span>
                        Total de venta
                    </span>

                    <strong class="total">

                        S/
                        {{ number_format($venta->total, 2) }}

                    </strong>

                </div>


                <div class="card">

                    <span>
                        Saldo pendiente
                    </span>

                    <strong class="saldo">

                        S/
                        {{ number_format($venta->saldo_pendiente, 2) }}

                    </strong>

                </div>

            </div>


            <div class="info">

                El pago no puede ser mayor al saldo pendiente.

                <br>

                Saldo máximo permitido:

                <strong>
                    S/
                    {{ number_format($venta->saldo_pendiente, 2) }}
                </strong>

            </div>


            <form
                method="POST"
                action="{{ route('pagos.store', $venta) }}">

                @csrf


                {{-- FECHA --}}

                <div class="form-group">

                    <label>
                        Fecha
                    </label>

                    <input
                        type="datetime-local"
                        name="fecha"
                        value="{{ old('fecha', now()->format('Y-m-d\TH:i')) }}"
                        disabled>
                        

                </div>


                {{-- MONTO --}}

                <div class="form-group">

                    <label>
                        Monto del pago
                    </label>

                    <input
                        type="number"
                        name="monto"
                        id="monto"
                        step="0.01"
                        min="0.01"
                        max="{{ $venta->saldo_pendiente }}"
                        value="{{ old('monto') }}"
                        placeholder="0.00"
                        required>

                </div>


                {{-- MEDIO DE PAGO --}}

                <div class="form-group">

                    <label>
                        Medio de pago
                    </label>

                    <select
                        name="medio_pago"
                        id="medio_pago"
                        required>

                        <option value="">
                            Seleccione
                        </option>

                        <option
                            value="EFECTIVO"
                            {{ old('medio_pago') === 'EFECTIVO' ? 'selected' : '' }}>
                            Efectivo
                        </option>

                        <option
                            value="DEPOSITO"
                            {{ old('medio_pago') === 'DEPOSITO' ? 'selected' : '' }}>
                            Depósito
                        </option>

                        <option
                            value="TRANSFERENCIA"
                            {{ old('medio_pago') === 'TRANSFERENCIA' ? 'selected' : '' }}>
                            Transferencia
                        </option>

                        <option
                            value="OTRO"
                            {{ old('medio_pago') === 'OTRO' ? 'selected' : '' }}>
                            Otro
                        </option>

                    </select>

                </div>


                {{-- OTRO MEDIO --}}

                <div
                    class="form-group"
                    id="medioOtroBox"
                    style="display:none;">

                    <label>
                        Especifique el medio de pago
                    </label>

                    <input
                        type="text"
                        name="medio_pago_otro"
                        value="{{ old('medio_pago_otro') }}"
                        maxlength="100">

                </div>


                {{-- OBSERVACION --}}

                <div class="form-group">

                    <label>
                        Observación
                    </label>

                    <textarea
                        name="observacion"
                        placeholder="Observación opcional...">{{ old('observacion') }}</textarea>

                </div>


                {{-- ACCIONES --}}

                <div class="acciones">

                    <a
                        href="{{ route('pagos.index', $venta) }}"
                        class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Registrar pago
                    </button>

                </div>

            </form>

        </div>

    </div>


    <script>
        const medioPago =
            document.getElementById('medio_pago');

        const medioOtroBox =
            document.getElementById('medioOtroBox');


        function actualizarMedioPago() {
            if (medioPago.value === 'OTRO') {

                medioOtroBox.style.display = 'block';

            } else {

                medioOtroBox.style.display = 'none';

            }
        }


        medioPago.addEventListener(
            'change',
            actualizarMedioPago
        );


        actualizarMedioPago();
    </script>

</body>

</html>
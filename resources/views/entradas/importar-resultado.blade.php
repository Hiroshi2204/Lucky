<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Resultado de importación</title>

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
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
        }

        .header p {
            margin-top: 6px;
            color: #6b7280;
        }

        .resumen {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        }

        .card small {
            display: block;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .card strong {
            font-size: 28px;
        }

        .procesadas {
            color: #2563eb;
        }

        .exitosas {
            color: #16a34a;
        }

        .errores {
            color: #dc2626;
        }

        .panel {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        }

        .panel h2 {
            margin-bottom: 20px;
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

        .estado {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .ok {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 16px;
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

        .btn-success {
            background: #16a34a;
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
                📊 Resultado de importación
            </h1>

            <p>
                Resultado de la carga masiva de productos y stock.
            </p>

        </div>


        {{-- ===================================================== --}}
        {{-- RESUMEN --}}
        {{-- ===================================================== --}}

        <div class="resumen">

            <div class="card">

                <small>
                    Filas procesadas
                </small>

                <strong class="procesadas">
                    {{ $import->procesadas }}
                </strong>

            </div>


            <div class="card">

                <small>
                    Importadas correctamente
                </small>

                <strong class="exitosas">
                    {{ $import->exitosas }}
                </strong>

            </div>


            <div class="card">

                <small>
                    Filas con errores
                </small>

                <strong class="errores">
                    {{ $import->errores }}
                </strong>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- DETALLE --}}
        {{-- ===================================================== --}}

        <div class="panel">

            <h2>
                Detalle de la importación
            </h2>

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Fila
                            </th>

                            <th>
                                Código
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Cantidad
                            </th>

                            <th>
                                Mensaje
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($import->resultado as $resultado)

                        <tr>

                            <td>
                                {{ $resultado['fila'] }}
                            </td>

                            <td>

                                <strong>
                                    {{ $resultado['codigo'] ?: '-' }}
                                </strong>

                            </td>

                            <td>

                                @if($resultado['estado'] === 'OK')

                                <span class="estado ok">
                                    OK
                                </span>

                                @else

                                <span class="estado error">
                                    ERROR
                                </span>

                                @endif

                            </td>

                            <td>

                                @if(isset($resultado['cantidad']))

                                {{ number_format(
                                        $resultado['cantidad'],
                                        3
                                    ) }}

                                @else

                                -

                                @endif

                            </td>

                            <td>

                                {{ $resultado['mensaje'] }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="5"
                                style="text-align:center;padding:30px;">

                                No se encontraron registros para procesar.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="acciones">

                <a
                    href="{{ route('entradas.index') }}"
                    class="btn btn-secondary">

                    ← Volver a entradas

                </a>


                <a
                    href="{{ route('entradas.importar.form') }}"
                    class="btn btn-primary">

                    📊 Nueva importación

                </a>

            </div>

        </div>

    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Importar productos</title>

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
            max-width: 800px;
            margin: auto;
            padding: 30px 20px;
        }

        .panel {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);
        }

        h1 {
            margin-bottom: 10px;
        }

        .descripcion {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
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
        }

        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 11px 18px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
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

        @media(max-width:600px) {

            .container {
                padding: 15px;
            }

            .panel {
                padding: 20px;
            }

            .acciones {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        <div class="panel">

            <h1>
                📊 Importar productos
            </h1>

            <p class="descripcion">
                Registra productos y su stock inicial mediante un archivo Excel.
            </p>

            <div class="info">

                <strong>
                    Formato del Excel
                </strong>

                <br><br>

                El archivo debe contener las siguientes columnas:

                <br><br>

                <strong>
                    codigo | descripcion | espesor | cantidad
                </strong>

                <br><br>

                Ejemplo:

                <br>

                P001 | Producto ejemplo | 0.010 | 100

            </div>

            @if($errors->any())

            <div style="
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

            <form
                method="POST"
                action="{{ route('entradas.importar') }}"
                enctype="multipart/form-data">

                @csrf

                <div class="form-group">

                    <label>
                        Archivo Excel
                    </label>

                    <input
                        type="file"
                        name="archivo"
                        accept=".xlsx,.xls,.csv"
                        required>

                </div>

                <div class="acciones">

                    <a
                        href="{{ route('entradas.index') }}"
                        class="btn btn-secondary">

                        ← Cancelar

                    </a>

                    <a
                        href="{{ route('entradas.importar.plantilla') }}"
                        class="btn btn-success">

                        📥 Descargar plantilla

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        📊 Importar archivo

                    </button>

                </div>
                <div style="
    background:#fef3c7;
    color:#92400e;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
">

                    <strong>Importante:</strong>

                    <ul style="margin-top:8px;margin-left:20px;">

                        <li>
                            El código identifica de manera única al producto.
                        </li>

                        <li>
                            Si el producto ya existe, se agregará la cantidad al stock.
                        </li>

                        <li>
                            Si el producto no existe, será creado automáticamente.
                        </li>

                        <li>
                            El espesor debe coincidir con el producto existente.
                        </li>

                        <li>
                            La cantidad debe ser mayor que cero.
                        </li>

                    </ul>

                </div>

            </form>

        </div>

    </div>

</body>

</html>
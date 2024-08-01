<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Equipos</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        .center-table {
            margin: 0 auto;
            border-collapse: collapse;
            border: 1px solid black;
            margin-bottom: 10px;
        }

        .center-table h4 {
            text-align: center;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 16px;
        }

        .center-table .subt {
            text-align: center;
            margin-top: -12px;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 12px;
        }

        .subt1 {
            text-align: center;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 12px;
        }

        .subt2 {
            text-align: center;
            padding-top: 5px;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 12px;
        }

        .subt3 {
            text-align: center;
            margin-top: -5px;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 12px;
        }

        .center-table h5 {
            text-align: center;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 13px;
        }

        .center-table h3 {
            text-align: center;
            color: #007FFF;
            font-family: "Arial MT";
            font-size: 16px;
        }

        .center-table td {
            line-height: 6px;
        }

        .imgk {
            text-align: center;
            vertical-align: middle;
            width: 10PX;
            height: 10PX;
        }

        .center-table1 {
            margin: 0 auto;
            border-collapse: collapse;
            border: 1px solid black;
            width: 75%;
            margin-bottom: 10px;
        }

        .center-table1 p {
            text-align: center;
        }

        .center-table2 {
            margin: 0 auto;
        }

        .center-table2 p {
            font-family: sans-serif;
            padding: 10px
        }

        .footer {
            text-align: center;
            vertical-align: middle;
            width: 150px;
            height: 150px;
        }

        .footer1 {
            margin-left: 10px;
        }

        .footer p {
            text-align: center;
        }

        .footer1 p {

            align-items: center;
            text-align: center;
            justify-content: center;
        }

        .justi {
            text-align: justify;
        }
        .center-table1 {
            text-align: center;
        }
    </style>
</head>
@csrf
<div style="text-align: center; margin-bottom: 10px;">
        <table style="width: 100%;" border="1" class="center-table">
            <tr>
                <td class="imgk"><img src="https://www.doblamos.com/wp-content/uploads/2021/10/estructuras-metalicas.png" width="500" height="15%"></td>
                <td style="padding: 0px; margin: 0px;" rowspan="2">
                    <p class="subt1">Versión 01</p>
                    <p class="subt1">Página 1</p>
                </td>
            </tr>
            <tr>
                <td style="padding: 0px; margin: 0px;">
                    <p class="subt1">MACROTECHOS LOPEZ S.A.C</p>
                </td>
            </tr>
        </table>
    </div>

    <br>
    <div style="text-align: right; margin-bottom: 10px;">
        <p style="margin: 0;">Fecha del Reporte: {{ date('Y-m-d') }}</p>
        <p style="margin: 0;">Hora del Reporte: {{ date('H:i:s') }}</p>
    </div>
    <br>
    <h3 style="text-align: center;">Reporte de Ventas de Productos</h3>
    @if(count($datos) > 0)
    <table border="1" class="center-table1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Codigo de Producto</th>
                <th>Color</th>
                <th>Cantidad por m2</th>
                <th>Precio</th>
                
                <th>Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datos as $detalle)
            <tr>
                <td>{{ $detalle['nom_producto'] }}</td>
                <td>{{ $detalle['cod_producto'] }}</td>
                <td>{{ $detalle['color'] }}</td>
                <td>{{ $detalle['largo'] }}</td>
                <td>s/. {{ $detalle['precio_total'] }}</td>
                
                <td> s/. {{ $detalle['ganancia_total'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No hay datos disponibles para mostrar en el informe.</p>
    @endif
    <br>
</body>

</html>
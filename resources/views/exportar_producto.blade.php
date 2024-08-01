<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <title>Salida</title>
    <style>
        body {
            background-image: url('https://st3.depositphotos.com/6550340/19239/i/450/depositphotos_192395946-stock-photo-metal-slate-roof-background.jpg');
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
</head>

<body>
    @csrf
    <br><br>
    <div class="container" style="background-color: #A5FFEF;">
        <br>
        <h2 class="text-center" style="color: red;">SALIDA DE LOS PRODUCTOS AL ALMACEN</h2>
        <div class="d-flex justify-content-center align-items-center" style="height: 10vh;">
            <button type="button" class="btn btn-primary" id="btnCancelar" style="background-color: #B92727; color:aliceblue">Salir</button>
        </div>
        <br>
        <form action="{{ route('exportar_producto') }}" method="post">
            @csrf
            <div class="d-flex justify-content-center align-items-center" style="height: 5vh;">
                <button type="submit" class="btn btn-primary mx-auto d-block" style="width: 60%;" onclick="mostrarAlerta()">Exportar Productos</button>
            </div>
            <br><br>
            <!-- <div class="form-group">
                <label for="destinatario_id">Escoge el Destinatario</label>
                <select class="form-control" name="destinatario_id">
                    <option value="">Selecciona un Destinatario</option>
                    <?php
                    $conexion = new mysqli("localhost", "root", "", "lucky");

                    if ($conexion->connect_error) {
                        die("Conexión fallida: " . $conexion->connect_error);
                    }

                    $consulta = "SELECT id, destinatario FROM destinatario";
                    $resultado = $conexion->query($consulta);

                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<option value='{$fila['id']}'>{$fila['destinatario']}</option>";
                    }
                    $conexion->close();
                    ?>
                </select>
            </div> -->
            <div class="row" id="productos-container">

                <aside class="col-sm-4">
                    <div class="card">
                        <article class="card-body">
                            <h4 class="card-title mb-4 mt-1">Salida de Producto</h4>

                            <div class="form-group">
                                <label for="productos[0][id]">Escoge el Producto</label>
                                <select class="form-control producto-select" name="productos[0][id]">
                                    <option value="">Selecciona un Producto por codigo</option>
                                    <?php
                                    $conexion = new mysqli("localhost", "root", "", "lucky");

                                    if ($conexion->connect_error) {
                                        die("Conexión fallida: " . $conexion->connect_error);
                                    }

                                    $consulta = "SELECT id, cod_producto FROM producto WHERE estado_registro = 'A'";
                                    $resultado = $conexion->query($consulta);

                                    while ($fila = $resultado->fetch_assoc()) {
                                        echo "<option value='{$fila['id']}'>{$fila['cod_producto']}</option>";
                                    }
                                    $conexion->close();
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productos[0][largo]">Largo del Producto</label>
                                <input name="productos[0][largo]" class="form-control" placeholder="0" type="text">
                            </div>
                            <div class="form-group">
                                <label for="productos[0][precio]">Precio del Producto</label>
                                <input name="productos[0][precio]" class="form-control" placeholder="Precio" type="text">
                            </div>
                        </article>
                    </div>
                    <br>
                </aside>

            </div>

        </form>
        <!-- <div class="col-sm-4">
            <button class="btn btn-primary" id="agregarProducto">Agregar otro producto</button>
        </div> -->
        <br>

    </div>
    <br><br>
    <script>
        $(document).ready(function() {
            var contador = 1; // Inicializar el contador

            // Manejar el clic en el botón "Agregar otro producto"
            $("#agregarProducto").click(function() {
                // Clona el primer aside y agrega la copia después del último aside
                var nuevoAside = $("aside:first").clone();
                nuevoAside.find("input, select").val(''); // Limpiar valores de los campos
                nuevoAside.find("[name^='productos[0]']").each(function() {
                    // Actualizar el nombre de los campos usando el nuevo índice
                    var nuevoNombre = $(this).attr("name").replace("[0]", "[" + contador + "]");
                    $(this).attr("name", nuevoNombre);
                });
                nuevoAside.appendTo("#productos-container");
                contador++; // Incrementar el contador
            });
        });
        function mostrarAlerta() {
            var mensaje = "¡No hay suficientes productos!";
            var tipoAlerta = "danger"; // Puedes cambiar a "info", "warning" o "success" según el caso

            // Crea la alerta usando Bootstrap
            var alerta = `<div class="alert alert-${tipoAlerta} alert-dismissible fade show" role="alert">
                            ${mensaje}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>`;

            // Agrega la alerta al final del cuerpo del documento
            $('body').append(alerta);
        }
    </script>
    <script>
        document.getElementById('btnCancelar').onclick = function() {
            window.history.back();
        };
    </script>
    <script>
        function mostrarAlerta() {
            // Personaliza el mensaje y tipo de alerta según tus necesidades
            var mensaje = "¡Producto guardado correctamente!";
            var tipoAlerta = "success"; // Puedes cambiar a "info", "warning" o "danger" según el caso

            // Crea la alerta usando Bootstrap
            var alerta = `<div class="alert alert-${tipoAlerta} alert-dismissible fade show" role="alert">
                        ${mensaje}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;

            // Agrega la alerta al final del cuerpo del documento
            $('body').append(alerta);
        }
    </script>

</body>

</html>
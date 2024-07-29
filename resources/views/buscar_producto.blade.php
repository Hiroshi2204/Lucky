<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    body {
        /* background-color: #EF4343; */
        background: url('https://img.freepik.com/foto-gratis/representacion-3d-fondo-abstracto-blanco-negro_23-2150913879.jpg') no-repeat center center fixed;
        background-size: cover;
        /* Hace que la imagen cubra toda la pantalla */
        background-position: center;
        /* Centra la imagen en la pantalla */
        background-attachment: fixed;
    }

    .contact {
        padding: 4%;
        height: 400px;
    }

    .col-md-3 {
        background: #ff9b00;
        padding: 4%;
        border-top-left-radius: 0.5rem;
        border-bottom-left-radius: 0.5rem;
    }

    .contact-info {
        margin-top: 10%;
    }

    .contact-info img {
        margin-bottom: 15%;
        width: 80%;
        height: 40%;
        display: block;
        margin: 0 auto;
    }

    .contact-info h2 {
        margin-bottom: 10%;
    }

    .col-md-9 {
        background-color: #A5FFEF;
        /* background: url('https://theliftco.eu/wp-content/uploads/2019/09/Empresa-de-aires-acondicionados-3.jpg') no-repeat center center fixed; */
        padding: 3%;
        border-top-right-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }

    .contact-form label {
        font-weight: 600;
    }

    .contact-form button {
        background: #25274d;
        color: #fff;
        font-weight: 600;
        width: 25%;
    }

    .contact-form button:focus {
        box-shadow: none;
    }
</style>
@csrf
<div class="container contact">
    <div class="row">
        <div class="col-md-3">
            <div class="contact-info">
                <!-- <img src="https://cdn.icon-icons.com/icons2/1526/PNG/512/checklist_106575.png" alt="image" /> -->
                <h2>Mira los Productos !!!</h2>
                <h4>No puede faltar ningun producto </h4>
            </div>
        </div>
        <div class="col-md-9">
            <div class="contact-form">

                <div class="form-group" style="background-color:antiquewhite;">
                    <h3 class="control-label col-sm-5" for="numero_documento">Tabla de Productos:</h3>
                    @if($datos)
                    <table border="2" class="center-table1 text-center">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Color</th>
                                <th>Estado de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datos as $producto)
                            <tr>
                                <td>{{$producto['cod_producto']}}</td>
                                <td>{{$producto['nom_producto']}}</td>
                                <td>{{$producto['largo']}}</td>
                                <td>{{$producto['color']}}</td>
                                <td>{{$producto['estado_registro']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No hay Productos por mostrar . . .</p>
                    @endif
                </div>
                <br>
                <!-- <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Guardar</button>
                    </div>
                    <br>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default" id="btnCancelar" style="background-color: #B92727;">Cancelar</button>
                    </div>
                    <script>
                        document.getElementById('btnCancelar').onclick = function() {
                            // Redirigir a la vista anterior (usando el historial del navegador)
                            window.history.back();
                        };
                    </script>
                </div> -->
            </div>
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default" id="btnCancelar" style="background-color: #ff1313;">Salir</button>
            </div>
            <script>
                document.getElementById('btnCancelar').addEventListener('click', function() {
                    window.history.back();
                });
            </script>
        </div>
        <br><br><br><br><br>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </div>
    <br><br><br>
</div>
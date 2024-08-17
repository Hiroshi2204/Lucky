<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Principal</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/main.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background: url('https://img.freepik.com/foto-gratis/fondo-material-hierro-rayas-verticales_23-2148801255.jpg') no-repeat center center fixed;
      /* Propiedades para hacer que la imagen de fondo cubra toda la pantalla */
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }

    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 2rem;
      background-color: #0deaea;
    }

    .logo {
      max-width: 550px;
    }

    .nav-list {
      list-style-type: none;
      display: flex;
      gap: 1rem;
    }

    .nav-list li a {
      text-decoration: none;
      color: #1c1c1c;
    }

    .abrir-menu,
    .cerrar-menu {
      display: none;
    }

    @media screen and (max-width: 550px) {

      .abrir-menu,
      .cerrar-menu {
        display: block;
        border: 0;
        font-size: 1.25rem;
        background-color: transparent;
        cursor: pointer;
      }

      .abrir-menu {
        color: #1c1c1c;
      }

      .cerrar-menu {
        color: #ececec;
      }

      .nav {
        opacity: 0;
        visibility: hidden;
        display: flex;
        flex-direction: column;
        align-items: end;
        gap: 1rem;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        background-color: #1c1c1c;
        padding: 2rem;
        box-shadow: 0 0 0 100vmax rgba(0, 0, 0, .5);
      }

      .nav.visible {
        opacity: 1;
        visibility: visible;
      }

      .nav-list {
        flex-direction: column;
        align-items: end;
      }

      .nav-list li a {
        color: #ecececec;
      }
    }

    #contenedor {
      width: 300px;
      height: 160px;
      border-top: 4px dashed #A7A7A7;
      border-right: 5px solid #A7A7A7;
      border-bottom: 4px double #A7A7A7;
      border-left: 5px dotted #A7A7A7;
      /* border: 2px solid #A7A7A7; */
      overflow: auto;
      /* Habilita la barra de desplazamiento cuando sea necesario */
      background-size: cover;
      background-color: #AC0000;
      color: #ececec;

    }

    .nav-item::after {
      content: '';
      display: block;
      width: 0px;
      height: 4px;
      background: #ff0000;
      transition: 0.2s;
      margin-top: -10px;
    }

    .nav-item:hover::after {
      width: 100%;
    }


    .nav-link {
      padding: 15px 5px;
      transition: 0.2s;
    }

    .navbar-nav .nav-link {

      color: #000;
      font-weight: bold;
      font-size: 18px;
    }

    .navbar-nav .active>.nav-link {

      width: 100%;
      height: 51px;

      border-bottom: .25rem solid transparent;
      border-bottom-color: #ed4137;

    }
  </style>
</head>

<body>
  @csrf
  <header>
    <img class="logo"  src="{{ asset('img\logo.png') }}" alt="Logo" style="width: 2000px; height: 80px;">
    <!-- <img class="logo" src="" alt="Logo"> -->
    <button id="abrir" class="abrir-menu"><i class="bi bi-list"></i></button>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <ul class="navbar-nav">
        <li class="active">
          <a href="#" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item dropdown"> <!-- Agrega la clase dropdown al elemento principal -->
          <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Productos y Equipos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('registrar_producto')}}">Registrar Productos</a></li>
            <li><a class="dropdown-item" href="{{route('buscar_producto')}}">Ver Productos</a></li>
            <!-- <li><a class="dropdown-item" href="{{route('actualizar_producto')}}">Actualizar un Producto</a></li>
            <li><a class="dropdown-item" href="{{route('eliminar_producto')}}">Eliminar un Producto</a></li> -->
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{route('asignar_producto')}}">Entrada Productos</a></li>
            <li><a class="dropdown-item" href="{{route('exportar_producto')}}">Salida Productos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown"> <!-- Agrega la clase dropdown al elemento principal -->
          <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Egresos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('registrar_egreso') }}">Egresos adicionales</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown"> <!-- Agrega la clase dropdown al elemento principal -->
          <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Reportes
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('generar_pdf_entrada') }}">Reportes de Entrada</a></li>
            <li><a class="dropdown-item" href="{{ route('generar_pdf_salida') }}">Reportes de Salida</a></li>
            <li><a class="dropdown-item" href="{{ route('generar_pdf_egreso') }}">Reportes de Gastos Adicionales</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('generar_pdf_stock') }}">Consulta de Stock de Productos</a></li>
            <li><a class="dropdown-item" href="{{ route('generar_pdf_precio') }}">Consulta de Precio</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('login') }}" class="nav-link" onclick="event.preventDefault(); showLogoutConfirmation()">Cerrar Sesión</a>
        </li>
      </ul>
    </nav>
  </header>
  <script>
    function showLogoutConfirmation() {
      var confirmLogout = confirm('¿Estás seguro de que deseas cerrar sesión?');

      if (confirmLogout) {
        // Si el usuario confirma, redirige al enlace de cierre de sesión
        window.location.href = "{{ route('login') }}";
      } else {
        // Si el usuario cancela, puedes realizar alguna otra acción o simplemente no hacer nada
        // Puedes agregar aquí un mensaje de cancelación si lo deseas
      }
    }
  </script>
  <script src="./js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <div id="contenedor">
    <!-- Contenido que puede necesitar desplazamiento -->
    <br>
    <h5 style="text-align: center;">Datos Personales:</h5>
    <p style="padding-left: 10px;">Nombre: {{$nombres}}</p>
    <p style="padding-left: 10px;">Apellidos: {{$apellido_paterno}} {{$apellido_materno}}</p>
    <!-- Más contenido aquí -->
  </div>
  <div id="contenedor">
    <!-- Contenido que puede necesitar desplazamiento -->
    <br>
    <h5 style="text-align: center;">Tu Usuario y DNI: </h5>
    <p style="padding-left: 10px;">Usuario: {{$username}}</p>
    <p style="padding-left: 10px;">DNI: {{$username}}</p>
    <!-- Más contenido aquí -->
  </div>
  <div id="contenedor">
    <!-- Contenido que puede necesitar desplazamiento -->
    <br>
    <h5 style="text-align: center;">Tu Celular y Correo: </h5>
    <p style="padding-left: 10px;">Celular: {{$celular}}</p>
    <p style="padding-left: 10px;">Correo: {{$correo}}</p>
    <!-- Más contenido aquí -->
  </div>

</body>

</html>
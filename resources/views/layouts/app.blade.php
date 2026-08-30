@php
use App\Helpers\LocalHelper;
@endphp
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>
        @yield('title', 'Macrotechos Inventario')
    </title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    @yield('head')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .app-container {
            width: 100%;
            max-width: 1400px;
            margin: auto;
            padding: 20px;
        }

        .navbar {
            background: white;
            border-radius: 12px;
            padding: 12px 15px;
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .06);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
            white-space: nowrap;
        }

        .nav-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 9px 12px;
            border-radius: 8px;

            text-decoration: none;
            color: #374151;

            font-size: 14px;
            font-weight: 500;

            transition: all .2s ease;
        }

        .nav-link:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .nav-link.active {
            background: #2563eb;
            color: white;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-title h1 {
            font-size: 28px;
        }

        .page-title p {
            margin-top: 5px;
            color: #6b7280;
            font-size: 14px;
        }

        @media(max-width: 900px) {

            .navbar {
                flex-direction: column;
                align-items: stretch;
            }

            .nav-brand {
                justify-content: center;
            }

            .nav-links {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                width: 100%;
            }

            .nav-link {
                justify-content: center;
            }
        }

        @media(max-width: 600px) {

            .app-container {
                padding: 12px;
            }

            .navbar {
                padding: 10px;
            }

            .nav-links {
                grid-template-columns: repeat(2, 1fr);
            }

            .nav-link {
                font-size: 13px;
                padding: 10px 6px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media(max-width: 400px) {

            .nav-links {
                grid-template-columns: 1fr;
            }
        }

        /* =====================================================
   PERFIL DE USUARIO
===================================================== */

        .profile-container {
            position: relative;
            margin-left: auto;
        }

        .profile-button {
            border: none;
            background: transparent;
            cursor: pointer;

            display: flex;
            align-items: center;
            gap: 10px;

            padding: 6px 10px;
            border-radius: 10px;

            font-family: inherit;

            transition: all .2s ease;
        }

        .profile-button:hover {
            background: #f3f4f6;
        }


        /* Avatar */

        .profile-avatar {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #2563eb;
            color: white;

            border-radius: 50%;

            font-size: 18px;
        }

        .profile-avatar-large {
            width: 42px;
            height: 42px;
        }


        /* Información */

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            line-height: 1.2;
        }

        .profile-name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        .profile-role {
            font-size: 12px;
            color: #6b7280;
        }


        /* Flecha */

        .profile-arrow {
            font-size: 10px;
            color: #6b7280;

            transition: transform .2s ease;
        }

        .profile-container.open .profile-arrow {
            transform: rotate(180deg);
        }


        /* =====================================================
   MENÚ
===================================================== */

        .profile-menu {

            position: absolute;

            top: calc(100% + 10px);
            right: 0;

            width: 280px;

            background: white;

            border-radius: 12px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .12),
                0 2px 6px rgba(0, 0, 0, .05);

            border: 1px solid #e5e7eb;

            overflow: hidden;

            display: none;

            z-index: 9999;
        }

        .profile-container.open .profile-menu {
            display: block;
        }


        /* =====================================================
   CABECERA DEL MENÚ
===================================================== */

        .profile-menu-header {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 16px;

            background: #f8fafc;

            border-bottom: 1px solid #e5e7eb;
        }

        .profile-menu-header strong {
            display: block;

            font-size: 14px;

            color: #111827;
        }

        .profile-menu-header small {

            display: block;

            margin-top: 3px;

            color: #6b7280;

            font-size: 12px;
        }


        /* =====================================================
   LOCAL
===================================================== */

        .profile-local {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 14px 16px;

            background: #ffffff;
        }

        .profile-menu-icon {

            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eff6ff;

            border-radius: 8px;

            font-size: 17px;
        }

        .profile-local small {

            display: block;

            color: #6b7280;

            font-size: 11px;
        }

        .profile-local strong {

            display: block;

            margin-top: 2px;

            color: #1f2937;

            font-size: 13px;
        }


        /* =====================================================
   OPCIONES
===================================================== */

        .profile-menu-item {

            width: 100%;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 12px 16px;

            border: none;

            background: white;

            text-decoration: none;

            color: #374151;

            cursor: pointer;

            font-family: inherit;

            text-align: left;

            transition: background .2s ease;
        }

        .profile-menu-item:hover {

            background: #f3f4f6;

        }

        .profile-menu-item>span {

            width: 34px;
            height: 34px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #f3f4f6;

            border-radius: 8px;

            font-size: 16px;
        }

        .profile-menu-item strong {

            display: block;

            font-size: 13px;

            color: #374151;
        }

        .profile-menu-item small {

            display: block;

            margin-top: 2px;

            font-size: 11px;

            color: #9ca3af;
        }


        /* =====================================================
   DIVISOR
===================================================== */

        .profile-divider {

            height: 1px;

            background: #e5e7eb;

            margin: 4px 0;
        }


        /* =====================================================
   CERRAR SESIÓN
===================================================== */

        .logout-item:hover {
            background: #fef2f2;
        }

        .logout-item:hover strong {
            color: #dc2626;
        }

        .logout-item:hover>span {
            background: #fee2e2;
        }


        /* =====================================================
   RESPONSIVE
===================================================== */

        @media(max-width: 900px) {

            .profile-info {
                display: none;
            }

            .profile-button {
                padding: 5px;
            }

            .profile-arrow {
                display: none;
            }

        }

        @media(max-width: 600px) {

            .profile-menu {

                position: fixed;

                top: 70px;

                right: 12px;

                width: calc(100% - 24px);

                max-width: 320px;

            }

        }
    </style>

    {{-- CSS ESPECÍFICO DE LA VISTA --}}
    @yield('styles')

</head>

<body>

    <div class="app-container">

        <nav class="navbar">

            <a
                href="{{ route('dashboard') }}"
                class="nav-brand">
                <span>
                    Macrotechos Lopez S.A.C
                </span>

            </a>

            <div class="nav-links">

                <a
                    href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    🏠 Inicio
                </a>

                <a
                    href="{{ route('productos.index') }}"
                    class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                    📦 Productos
                </a>

                <a
                    href="{{ route('entradas.index') }}"
                    class="nav-link {{ request()->routeIs('entradas.*') ? 'active' : '' }}">
                    📥 Entradas
                </a>

                <a
                    href="{{ route('ventas.index') }}"
                    class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                    🛒 Ventas
                </a>

                <a
                    href="{{ route('reportes.index') }}"
                    class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                    📊 Reportes
                </a>

                @if(auth()->user()->rol_id == 1)

                <a
                    href="{{ route('auditorias.index') }}"
                    class="nav-link {{ request()->routeIs('auditorias.*') ? 'active' : '' }}">
                    🔎 Auditoría
                </a>

                @endif

                @if(auth()->user()->rol_id == 1)

                <a
                    href="{{ route('usuarios.index') }}"
                    class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                    👥 Usuarios
                </a>

                @endif

            </div>
            {{-- PERFIL DEL USUARIO --}}
            <div class="profile-container">

                <button
                    type="button"
                    class="profile-button"
                    onclick="toggleProfileMenu()">

                    <div class="profile-avatar">
                        👤
                    </div>

                    <div class="profile-info">

                        <span class="profile-name">
                            {{ auth()->user()->username }}
                        </span>

                        <span class="profile-role">
                            {{ auth()->user()->rol_id == 1 ? 'Administrador' : 'Trabajador' }}
                        </span>

                    </div>

                    <span class="profile-arrow">
                        ▼
                    </span>

                </button>


                {{-- MENÚ DESPLEGABLE --}}
                <div
                    id="profileMenu"
                    class="profile-menu">

                    {{-- CABECERA --}}
                    <div class="profile-menu-header">

                        <div class="profile-avatar profile-avatar-large">
                            👤
                        </div>

                        <div>

                            <strong>
                                {{ auth()->user()->username }}
                            </strong>

                            <small>
                                {{ auth()->user()->rol_id == 1 ? 'Administrador' : 'Trabajador' }}
                            </small>

                        </div>

                    </div>


                    {{-- INFORMACIÓN DEL LOCAL --}}
                    <div class="profile-local">

                        <span class="profile-menu-icon">
                            🏢
                        </span>

                        <div>

                            <small>Local actual</small>

                            <strong>
                                {{ LocalHelper::nombre() ?? 'Local no seleccionado' }}
                            </strong>

                        </div>

                    </div>


                    {{-- CAMBIAR LOCAL SOLO ADMIN --}}
                    @if(auth()->user()->rol_id == 1)

                    <a
                        href="{{ route('local.cambiar') }}"
                        class="profile-menu-item">

                        <span>🔄</span>

                        <div>
                            <strong>Cambiar local</strong>
                            <small>Seleccionar otro local</small>
                        </div>

                    </a>

                    @endif


                    <div class="profile-divider"></div>


                    {{-- CERRAR SESIÓN --}}
                    <form
                        action="{{ route('logout') }}"
                        method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="profile-menu-item logout-item">

                            <span>🚪</span>

                            <div>
                                <strong>Cerrar sesión</strong>
                                <small>Salir del sistema</small>
                            </div>

                        </button>

                    </form>

                </div>

            </div>


        </nav>



        <main>

            @yield('content')

        </main>

    </div>

    <script>
        function toggleProfileMenu() {

            const container = document.querySelector('.profile-container');

            container.classList.toggle('open');

        }


        // Cerrar cuando se haga clic fuera
        document.addEventListener('click', function(event) {

            const container = document.querySelector('.profile-container');

            if (!container) {
                return;
            }

            if (!container.contains(event.target)) {

                container.classList.remove('open');

            }

        });
    </script>
    @yield('scripts')

</body>

</html>
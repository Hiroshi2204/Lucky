<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Lucky Inventario')
    </title>

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

                📦

                <span>
                    Lucky Inventario
                </span>

            </a>

            <div class="nav-links">

                <a
                    href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
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

            </div>

        </nav>

        <main>

            @yield('content')

        </main>

    </div>

    {{-- JAVASCRIPT ESPECÍFICO DE LA VISTA --}}
    @yield('scripts')

</body>

</html>
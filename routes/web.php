<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\ImportacionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\PasswordController;
use App\Http\Middleware\ForcePasswordChange;
use Illuminate\Support\Facades\Route;

Route::get('/login', [
    AuthController::class,
    'login'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'authenticate'
])->name('login.authenticate');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');

/*
|--------------------------------------------------------------------------
| CAMBIO OBLIGATORIO DE CONTRASEÑA
|--------------------------------------------------------------------------
|
| Estas rutas requieren autenticación, pero NO el middleware
| ForcePasswordChange porque justamente son las rutas que permiten
| salir del estado de contraseña temporal.
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/cambiar-password', [
        PasswordController::class,
        'edit'
    ])->name('password.change');

    Route::post('/cambiar-password', [
        PasswordController::class,
        'update'
    ])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    ForcePasswordChange::class
])->group(function () {

    Route::get('/local/seleccionar', [
        LocalController::class,
        'seleccionar'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('local.seleccionar');

    Route::post('/local/seleccionar', [
        LocalController::class,
        'guardar'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('local.guardar');

    Route::get('/local/cambiar', [
        LocalController::class,
        'cambiar'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('local.cambiar');

    Route::get('/usuarios', [
        UserController::class,
        'index'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('usuarios.index');

    Route::get('/usuarios/crear', [
        UserController::class,
        'create'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('usuarios.create');

    Route::post('/usuarios', [
        UserController::class,
        'store'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('usuarios.store');

    Route::patch('/usuarios/{usuario}/estado', [
        UserController::class,
        'cambiarEstado'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('usuarios.estado');

    Route::get('/auditorias', [
        AuditoriaController::class,
        'index'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('auditorias.index');

    Route::get('/auditorias/{auditoria}', [
        AuditoriaController::class,
        'show'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('auditorias.show');

    Route::get('/usuarios/{usuario}/edit', [
        UserController::class,
        'edit'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('usuarios.edit');

    Route::put('/usuarios/{usuario}', [
        UserController::class,
        'update'
    ])
        ->middleware('role:ADMINISTRADOR')
        ->name('usuarios.update');
});

Route::middleware([
    'auth',
    'local',
    ForcePasswordChange::class
])->group(function () {

    Route::get('/dashboard', [
        DashboardController::class,
        'vista'
    ])->name('dashboard');

    Route::get(
        'entradas/importar',
        [ImportacionController::class, 'index']
    )->name('entradas.importar');

    Route::post(
        'entradas/importar',
        [ImportacionController::class, 'entradas']
    )->name('entradas.importar.procesar');

    Route::get(
        'entradas/importar/plantilla',
        [ImportacionController::class, 'plantillaEntradas']
    )->name('entradas.importar.plantilla');

    Route::get(
        'productos/buscar',
        [ProductoController::class, 'buscar']
    )->name('api.productos.buscar');

    Route::get(
        'productos/buscar-venta',
        [ProductoController::class, 'buscarVenta']
    )->name('api.productos.buscarVenta');

    Route::resource(
        'productos',
        ProductoController::class
    );

    Route::resource(
        'entradas',
        EntradaController::class
    )->only([
        'index',
        'create',
        'store',
        'show'
    ]);

    Route::get('/ventas', [
        VentaController::class,
        'index'
    ])->name('ventas.index');

    Route::get('/ventas/create', [
        VentaController::class,
        'create'
    ])->name('ventas.create');

    Route::post('/ventas', [
        VentaController::class,
        'store'
    ])->name('ventas.store');

    Route::get('/ventas/{venta}', [
        VentaController::class,
        'show'
    ])->name('ventas.show');

    Route::post('/ventas/{venta}/anular', [
        VentaController::class,
        'anular'
    ])->name('ventas.anular');

    Route::get(
        '/ventas/{venta}/pagos',
        [PagoController::class, 'index']
    )->name('pagos.index');

    Route::get(
        '/ventas/{venta}/pagos/create',
        [PagoController::class, 'create']
    )->name('pagos.create');

    Route::post(
        '/ventas/{venta}/pagos',
        [PagoController::class, 'store']
    )->name('pagos.store');

    Route::get(
        '/pagos/{pago}',
        [PagoController::class, 'show']
    )->name('pagos.show');

    /*
    |--------------------------------------------------------------------------
    | REPORTES
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes', [
        ReporteController::class,
        'index'
    ])->name('reportes.index');

    Route::get('/reportes/inventario', [
        ReporteController::class,
        'inventario'
    ])->name('reportes.inventario');

    Route::get('/reportes/inventario/pdf', [
        ReporteController::class,
        'inventarioPdf'
    ])->name('reportes.inventario.pdf');

    Route::get('/reportes/inventario/excel', [
        ReporteController::class,
        'inventarioExcel'
    ])->name('reportes.inventario.excel');

    Route::get('/reportes/movimientos', [
        ReporteController::class,
        'movimientos'
    ])->name('reportes.movimientos');

    Route::get('/reportes/movimientos/pdf', [
        ReporteController::class,
        'movimientosPdf'
    ])->name('reportes.movimientos.pdf');

    Route::get('/reportes/movimientos/excel', [
        ReporteController::class,
        'movimientosExcel'
    ])->name('reportes.movimientos.excel');

    Route::get('/reportes/ventas', [
        ReporteController::class,
        'ventas'
    ])->name('reportes.ventas');

    Route::get('/reportes/ventas/pdf', [
        ReporteController::class,
        'ventasPdf'
    ])->name('reportes.ventas.pdf');

    Route::get('/reportes/ventas/excel', [
        ReporteController::class,
        'ventasExcel'
    ])->name('reportes.ventas.excel');

    Route::get('/reportes/pagos', [
        ReporteController::class,
        'pagos'
    ])->name('reportes.pagos');

    Route::get('/reportes/pagos/pdf', [
        ReporteController::class,
        'pagosPdf'
    ])->name('reportes.pagos.pdf');

    Route::get('/reportes/pagos/excel', [
        ReporteController::class,
        'pagosExcel'
    ])->name('reportes.pagos.excel');
});

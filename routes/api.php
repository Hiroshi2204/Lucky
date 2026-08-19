<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ImportacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| PRODUCTOS
|--------------------------------------------------------------------------
*/

Route::get(
    'productos/buscar',
    [ProductoController::class, 'buscar']
)->name('api.productos.buscar');

Route::get(
    'productos/buscar-venta',
    [ProductoController::class, 'buscarVenta']
)->name('api.productos.buscarVenta');

Route::apiResource(
    'productos',
    ProductoController::class
)->names([
    'index'   => 'api.productos.index',
    'store'   => 'api.productos.store',
    'show'    => 'api.productos.show',
    'update'  => 'api.productos.update',
    'destroy' => 'api.productos.destroy',
]);


/*
|--------------------------------------------------------------------------
| ENTRADAS
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'entradas',
    EntradaController::class
)->only([
    'index',
    'store',
    'show'
])->names([
    'index' => 'api.entradas.index',
    'store' => 'api.entradas.store',
    'show' => 'api.entradas.show',
]);


/*
|--------------------------------------------------------------------------
| MOVIMIENTOS
|--------------------------------------------------------------------------
*/

Route::get(
    'movimientos',
    [MovimientoController::class, 'index']
);

Route::get(
    'movimientos/{movimiento}',
    [MovimientoController::class, 'show']
);


/*
|--------------------------------------------------------------------------
| VENTAS
|--------------------------------------------------------------------------
*/

Route::get(
    'ventas',
    [VentaController::class, 'index']
);

Route::post(
    'ventas',
    [VentaController::class, 'store']
);

Route::get(
    'ventas/{venta}',
    [VentaController::class, 'show']
);

Route::post(
    'ventas/{venta}/anular',
    [VentaController::class, 'anular']
);



/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get(
    'dashboard',
    [DashboardController::class, 'index']
);


/*
|--------------------------------------------------------------------------
| REPORTES
|--------------------------------------------------------------------------
*/

Route::get(
    'reportes/inventario',
    [ReporteController::class, 'inventario']
);

Route::get(
    'reportes/ventas',
    [ReporteController::class, 'ventas']
);
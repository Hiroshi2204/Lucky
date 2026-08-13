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

// Route::get(
//     'productos/buscar',
//     [ProductoController::class, 'buscar']
// );

// Route::get(
//     'productos/{producto}/stock',
//     [ProductoController::class, 'stock']
// );

// Route::apiResource(
//     'productos',
//     ProductoController::class
// );
Route::get(
    'productos/buscar',
    [ProductoController::class, 'buscar']
)->name('productos.buscar');
Route::get(
    '/productos/buscar-venta',
    [ProductoController::class, 'buscarVenta']
)->name('productos.buscarVenta');
Route::apiResource(
    'productos',
    ProductoController::class
);


/*
|--------------------------------------------------------------------------
| ENTRADAS
|--------------------------------------------------------------------------
*/

// Route::get(
//     'entradas',
//     [EntradaController::class, 'index']
// );

// Route::post(
//     'entradas',
//     [EntradaController::class, 'store']
// );

// Route::get(
//     'entradas/{entrada}',
//     [EntradaController::class, 'show']
// );
Route::apiResource(
    'entradas',
    EntradaController::class
)->only([
    'index',
    'store',
    'show'
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
| IMPORTACIONES
|--------------------------------------------------------------------------
*/

Route::post(
    'importaciones/entradas',
    [ImportacionController::class, 'entradas']
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


Route::get(
    'reportes/inventario',
    [ReporteController::class, 'inventario']
);

Route::get(
    'reportes/ventas',
    [ReporteController::class, 'ventas']
);

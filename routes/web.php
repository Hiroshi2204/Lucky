<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\ImportacionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\VentaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get(
    '/',
    [DashboardController::class, 'vista']
)->name('dashboard');
// =====================================================
// IMPORTACIÓN MASIVA DE ENTRADAS
// =====================================================
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




Route::get('/ventas', [VentaController::class, 'index'])
    ->name('ventas.index');

Route::get('/ventas/create', [VentaController::class, 'create'])
    ->name('ventas.create');

Route::post('/ventas', [VentaController::class, 'store'])
    ->name('ventas.store');

Route::get('/ventas/{venta}', [VentaController::class, 'show'])
    ->name('ventas.show');

Route::post('/ventas/{venta}/anular', [VentaController::class, 'anular'])
    ->name('ventas.anular');



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

// REPORTES
Route::get('/reportes', [ReporteController::class, 'index'])
    ->name('reportes.index');


// INVENTARIO
Route::get('/reportes/inventario', [ReporteController::class, 'inventario'])
    ->name('reportes.inventario');

Route::get('/reportes/inventario/pdf', [ReporteController::class, 'inventarioPdf'])
    ->name('reportes.inventario.pdf');

Route::get('/reportes/inventario/excel', [ReporteController::class, 'inventarioExcel'])
    ->name('reportes.inventario.excel');


// MOVIMIENTOS
Route::get('/reportes/movimientos', [ReporteController::class, 'movimientos'])
    ->name('reportes.movimientos');

Route::get('/reportes/movimientos/pdf', [ReporteController::class, 'movimientosPdf'])
    ->name('reportes.movimientos.pdf');

Route::get('/reportes/movimientos/excel', [ReporteController::class, 'movimientosExcel'])
    ->name('reportes.movimientos.excel');


// VENTAS
Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])
    ->name('reportes.ventas');

Route::get('/reportes/ventas/pdf', [ReporteController::class, 'ventasPdf'])
    ->name('reportes.ventas.pdf');

Route::get('/reportes/ventas/excel', [ReporteController::class, 'ventasExcel'])
    ->name('reportes.ventas.excel');


// PAGOS
Route::get('/reportes/pagos', [ReporteController::class, 'pagos'])
    ->name('reportes.pagos');

Route::get('/reportes/pagos/pdf', [ReporteController::class, 'pagosPdf'])
    ->name('reportes.pagos.pdf');

Route::get('/reportes/pagos/excel', [ReporteController::class, 'pagosExcel'])
    ->name('reportes.pagos.excel');


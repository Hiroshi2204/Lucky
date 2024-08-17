<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportePDFController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/login', [LoginController::class, 'mostrar_login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
/*Route::get('/login', function () {
    return view('mostrar_login');
});*/
Route::get('/crear_usuario', [LoginController::class, 'mostrar_usuario'])->name('usuario');
Route::post('/crear_usuario', [UserController::class, 'create']);


Route::get('/menu/{id}', [LoginController::class, 'mostrar_menu'])->name('mostrar_menu');
Route::get('/generar_pdf_entrada', [ReportePDFController::class, 'reporte_equipos_entrada'])->name('generar_pdf_entrada');
Route::get('/generar_pdf_salida', [ReportePDFController::class, 'reporte_equipos_salida'])->name('generar_pdf_salida');
Route::get('/generar_pdf_stock', [ReportePDFController::class, 'reporte_equipos_stock'])->name('generar_pdf_stock');
Route::get('/generar_pdf_precio', [ReportePDFController::class, 'reporte_equipos_precio'])->name('generar_pdf_precio');
Route::get('/generar_pdf_egreso', [ReportePDFController::class, 'reporte_egreso'])->name('generar_pdf_egreso');

Route::get('/asignar_rol', [LoginController::class, 'asignar_rol'])->name('asignar_rol');
Route::post('/asignar_rol', [LoginController::class, 'crear_asignar_rol'])->name('rol_asignado');
Route::get('/cambiar_rol/{id}', [LoginController::class, 'cambiar_rol'])->name('cambiar_rol');
Route::post('/cambiar_rol/{id}', [LoginController::class, 'cambiar_rol_trabajador'])->name('cambiar_rol_trabajador');
Route::get('/buscar_trabajador', [LoginController::class, 'buscar_trabajador'])->name('buscar_trabajador');


Route::get('/almacen', [LoginController::class, 'almacen'])->name('almacen');



Route::get('/buscar_producto', [LoginController::class, 'buscar_producto'])->name('buscar_producto');

Route::get('/actualizar_producto', [LoginController::class, 'act_producto']);
Route::post('/actualizar_producto', [LoginController::class, 'actualizar_producto'])->name('actualizar_producto');

Route::get('/eliminar_producto', [LoginController::class, 'producto_eliminado']);
Route::post('/eliminar_producto', [LoginController::class, 'eliminar_producto'])->name('eliminar_producto');

Route::get('/asignar_producto', [LoginController::class, 'asignar_producto'])->name('asignar_producto');
// Route::get('/almacen', [LoginController::class, 'almacen'])->name('almacen');

Route::group(['middleware' => ['cors']], function () {
});
//Route::group(['middleware' => ['cors']], function () {
//Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
Route::middleware(['web'])->group(function () {
    // Rutas aquí
    Route::get('/registrar_producto', [LoginController::class, 'registrar_producto']);
    Route::post('/registrar_producto', [LoginController::class, 'crear_varios_producto'])->name('registrar_producto');

    Route::get('/asignar_producto', [LoginController::class, 'asignar_producto']);
    Route::post('/asignar_producto', [LoginController::class, 'asignar_varios_producto'])->name('asignar_producto');

    Route::get('/exportar_producto', [LoginController::class, 'exportar_productos']);
    Route::post('/exportar_producto', [LoginController::class, 'exportar_varios_productos'])->name('exportar_producto');

    //Proveedores y Destinatarios
    Route::get('/proveedor_crear', [LoginController::class, 'create_proveedor_mostrar']);
    Route::post('/proveedor_crear', [LoginController::class, 'create_proveedor'])->name('proveedor_crear');

    Route::get('/proveedor_actualizar', [LoginController::class, 'update_proveedor_mostrar']);
    Route::post('/proveedor_actualizar', [LoginController::class, 'update_proveedor'])->name('proveedor_actualizar');

    Route::get('/proveedor_eliminar', [LoginController::class, 'delete_proveedor_mostrar']);
    Route::post('/proveedor_eliminar', [LoginController::class, 'delete_proveedor'])->name('proveedor_eliminar');

    Route::get('/proveedor_ver', [LoginController::class, 'get_proveedor'])->name('proveedor_ver');
    //------------------------------------------------------------------------------
    Route::get('/destinatario_crear', [LoginController::class, 'create_destinatario_mostrar']);
    Route::post('/destinatario_crear', [LoginController::class, 'create_destinatario'])->name('destinatario_crear');

    Route::get('/destinatario_actualizar', [LoginController::class, 'update_destinatario_mostrar']);
    Route::post('/destinatario_actualizar', [LoginController::class, 'update_destinatario'])->name('destinatario_actualizar');

    Route::get('/destinatario_eliminar', [LoginController::class, 'delete_destinatario_mostrar']);
    Route::post('/destinatario_eliminar', [LoginController::class, 'delete_destinatario'])->name('destinatario_eliminar');

    Route::get('/destinatario_ver', [LoginController::class, 'get_destinatario'])->name('destinatario_ver');

    Route::get('/registrar_egreso', [LoginController::class, 'registrar_egreso']);
    Route::post('/registrar_egreso', [LoginController::class, 'crear_varios_egresos'])->name('registrar_egreso');
});
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {

    /*
    // Actualizar contraseña
    Route::put('password/update', 'AuthController@updatePassword');

    //Trabajador
    Route::post('trabajador/create','TrabajadorController@create');
    Route::put('trabajador/update/{id_trabajador}','TrabajadorController@update');
    Route::delete('trabajador/delete/{id_trabajador}','TrabajadorController@delete');
    Route::get('trabajador/get','TrabajadorController@get');

    //Persona
    Route::get('persona/show','PersonaController@getShow');
    Route::get('persona/get','PersonaController@get');
    Route::post('persona/store','PersonaController@store');
    Route::post('persona/update/{id}','PersonaController@update');
    Route::delete('persona/delete/{id}','PersonaController@delete');
    Route::delete('persona/destroy/{id}','PersonaController@destroy');
    //Producto
    Route::post('producto/create', 'ProductoController@create');
    Route::put('producto/update/{id}', 'ProductoController@update');
    Route::delete('producto/delete/{id}', 'ProductoController@delete');
    Route::get('producto/get', 'ProductoController@get');
    Route::post('producto/asignar/{id_producto}', 'ProductoController@asignar_almacen');
    //Salida y Entrada de Productos
    Route::post('producto/exportacion/{id_producto}', 'ProductoController@salida_productos');
    Route::post('producto/importar/{id_producto}', 'ProductoController@entrada_productos');

    //Reportes PDF's
    Route::get('/producto/reporte/entrada', 'ReportePDFController@reporte_equipos_entrada');
    Route::get('/producto/reporte/stock', 'ReportePDFController@reporte_equipos_stock');
    Route::get('/producto/reporte/salida', 'ReportePDFController@reporte_equipos_salida');
*/
});

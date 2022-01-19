<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/cuentaplantipo/index', [App\Http\Controllers\Contabilidad\CuentaPlanTipoController::class, 'index']);
Route::get('/cuentaplantipo/create', [App\Http\Controllers\Contabilidad\CuentaPlanTipoController::class, 'create']);
Route::post('/cuentaplantipo/store', [App\Http\Controllers\Contabilidad\CuentaPlanTipoController::class, 'store']);
Route::get('/cuentaplantipo/edit/{idcuentaplantipo}', [App\Http\Controllers\Contabilidad\CuentaPlanTipoController::class, 'edit']);
Route::post('/cuentaplantipo/update', [App\Http\Controllers\Contabilidad\CuentaPlanTipoController::class, 'update']);
Route::get('/cuentaplantipo/show/{idcuentaplantipo}', [App\Http\Controllers\Contabilidad\CuentaPlanTipoController::class, 'show']);
Route::post('/cuentaplantipo/delete/{idcuentaplantipo}', [App\Http\Controllers\Contabilidad\CuentaPlanTipoController::class, 'destroy']);

Route::get('/cuentaplan/index', [App\Http\Controllers\Contabilidad\CuentaPlanController::class, 'index']);
Route::get('/cuentaplan/create', [App\Http\Controllers\Contabilidad\CuentaPlanController::class, 'create']);
Route::post('/cuentaplan/store', [App\Http\Controllers\Contabilidad\CuentaPlanController::class, 'store']);
Route::get('/cuentaplan/edit/{idcuentaplan}', [App\Http\Controllers\Contabilidad\CuentaPlanController::class, 'edit']);
Route::post('/cuentaplan/update', [App\Http\Controllers\Contabilidad\CuentaPlanController::class, 'update']);
Route::get('/cuentaplan/show/{idcuentaplan}', [App\Http\Controllers\Contabilidad\CuentaPlanController::class, 'show']);
Route::post('/cuentaplan/delete/{idcuentaplan}', [App\Http\Controllers\Contabilidad\CuentaPlanController::class, 'destroy']);


Route::get('/proveedor/index', [App\Http\Controllers\Compra\ProveedorController::class, 'index']);
Route::get('/proveedor/create', [App\Http\Controllers\Compra\ProveedorController::class, 'create']);
Route::post('/proveedor/store', [App\Http\Controllers\Compra\ProveedorController::class, 'store']);
Route::get('/proveedor/edit/{idproveedor}', [App\Http\Controllers\Compra\ProveedorController::class, 'edit']);
Route::post('/proveedor/update', [App\Http\Controllers\Compra\ProveedorController::class, 'update']);
Route::get('/proveedor/show/{idproveedor}', [App\Http\Controllers\Compra\ProveedorController::class, 'show']);
Route::post('/proveedor/delete/{idproveedor}', [App\Http\Controllers\Compra\ProveedorController::class, 'destroy']);


Route::get('/servicio/index', [App\Http\Controllers\Venta\ServicioController::class, 'index']);
Route::get('/servicio/create', [App\Http\Controllers\Venta\ServicioController::class, 'create']);
Route::post('/servicio/store', [App\Http\Controllers\Venta\ServicioController::class, 'store']);
Route::get('/servicio/edit/{idservicio}', [App\Http\Controllers\Venta\ServicioController::class, 'edit']);
Route::post('/servicio/update', [App\Http\Controllers\Venta\ServicioController::class, 'update']);
Route::get('/servicio/show/{idservicio}', [App\Http\Controllers\Venta\ServicioController::class, 'show']);
Route::post('/servicio/delete/{idservicio}', [App\Http\Controllers\Venta\ServicioController::class, 'destroy']);

Route::get('/cliente/index', [App\Http\Controllers\Venta\ClienteController::class, 'index']);
Route::get('/cliente/create', [App\Http\Controllers\Venta\ClienteController::class, 'create']);
Route::post('/cliente/store', [App\Http\Controllers\Venta\ClienteController::class, 'store']);
Route::get('/cliente/edit/{idcliente}', [App\Http\Controllers\Venta\ClienteController::class, 'edit']);
Route::post('/cliente/update', [App\Http\Controllers\Venta\ClienteController::class, 'update']);
Route::get('/cliente/show/{idcliente}', [App\Http\Controllers\Venta\ClienteController::class, 'show']);
Route::post('/cliente/delete/{idcliente}', [App\Http\Controllers\Venta\ClienteController::class, 'destroy']);

Route::get('/terreno/index', [App\Http\Controllers\Venta\TerrenoController::class, 'index']);
Route::get('/terreno/create', [App\Http\Controllers\Venta\TerrenoController::class, 'create']);
Route::post('/terreno/store', [App\Http\Controllers\Venta\TerrenoController::class, 'store']);
Route::get('/terreno/edit/{idterreno}', [App\Http\Controllers\Venta\TerrenoController::class, 'edit']);
Route::post('/terreno/update', [App\Http\Controllers\Venta\TerrenoController::class, 'update']);
Route::get('/terreno/show/{idterreno}', [App\Http\Controllers\Venta\TerrenoController::class, 'show']);
Route::post('/terreno/delete/{idterreno}', [App\Http\Controllers\Venta\TerrenoController::class, 'destroy']);

Route::get('/venta/index', [App\Http\Controllers\Venta\VentaController::class, 'index']);
Route::get('/venta/create', [App\Http\Controllers\Venta\VentaController::class, 'create']);
Route::post('/venta/store', [App\Http\Controllers\Venta\VentaController::class, 'store']);
Route::get('/venta/edit/{idventa}', [App\Http\Controllers\Venta\VentaController::class, 'edit']);
Route::post('/venta/update', [App\Http\Controllers\Venta\VentaController::class, 'update']);
Route::get('/venta/show/{idventa}', [App\Http\Controllers\Venta\VentaController::class, 'show']);
Route::post('/venta/delete/{idventa}', [App\Http\Controllers\Venta\VentaController::class, 'destroy']);


Route::get('/formulario/index', [App\Http\Controllers\Seguridad\FormularioController::class, 'index']);
Route::get('/formulario/create', [App\Http\Controllers\Seguridad\FormularioController::class, 'create']);
Route::post('/formulario/store', [App\Http\Controllers\Seguridad\FormularioController::class, 'store']);
Route::get('/formulario/edit/{idformulario}', [App\Http\Controllers\Seguridad\FormularioController::class, 'edit']);
Route::post('/formulario/update', [App\Http\Controllers\Seguridad\FormularioController::class, 'update']);
Route::get('/formulario/show/{idformulario}', [App\Http\Controllers\Seguridad\FormularioController::class, 'show']);
Route::post('/formulario/delete/{idformulario}', [App\Http\Controllers\Seguridad\FormularioController::class, 'destroy']);

Route::get('/grupousuario/index', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'index']);
Route::get('/grupousuario/create', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'create']);
Route::post('/grupousuario/store', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'store']);
Route::get('/grupousuario/edit/{idgrupousuario}', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'edit']);
Route::post('/grupousuario/update', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'update']);
Route::get('/grupousuario/show/{idgrupousuario}', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'show']);
Route::post('/grupousuario/delete/{idgrupousuario}', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'destroy']);

Route::get('/grupousuario/getusuario/{idgrupousuario}', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'getusuario']);
Route::post('/grupousuario/asignarusuario', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'asignarusuario']);

Route::get('/grupousuario/getformulario/{idgrupousuario}', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'getformulario']);
Route::post('/grupousuario/asignarformulario', [App\Http\Controllers\Seguridad\GrupoUsuarioController::class, 'asignarformulario']);


Route::get('/usuario/index', [App\Http\Controllers\Seguridad\UsuarioController::class, 'index']);
Route::get('/usuario/create', [App\Http\Controllers\Seguridad\UsuarioController::class, 'create']);
Route::post('/usuario/store', [App\Http\Controllers\Seguridad\UsuarioController::class, 'store']);
Route::get('/usuario/edit/{idusuario}', [App\Http\Controllers\Seguridad\UsuarioController::class, 'edit']);
Route::post('/usuario/update', [App\Http\Controllers\Seguridad\UsuarioController::class, 'update']);
Route::get('/usuario/show/{idusuario}', [App\Http\Controllers\Seguridad\UsuarioController::class, 'show']);
Route::post('/usuario/delete/{idusuario}', [App\Http\Controllers\Seguridad\UsuarioController::class, 'destroy']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/plancuenta/index', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/plancuentatipo/index', [App\Http\Controllers\HomeController::class, 'index']);


Route::get('/proveedor/index', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/proveedor/create', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/proveedor/edit/{idproveedor}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/proveedor/show/{idproveedor}', [App\Http\Controllers\HomeController::class, 'index']);


Route::get('/cliente/index', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/cliente/create', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/cliente/edit/{idcliente}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/cliente/show/{idcliente}', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/servicio/index', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/servicio/create', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/servicio/edit/{idservicio}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/servicio/show/{idservicio}', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/terreno/index', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/terreno/create', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/terreno/edit/{idterreno}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/terreno/show/{idterreno}', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/venta/index', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/venta/create', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/venta/edit/{idventa}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/venta/show/{idventa}', [App\Http\Controllers\HomeController::class, 'index']);


Route::get('/formulario/index', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/formulario/create', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/formulario/edit/{idformulario}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/formulario/show/{idformulario}', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/grupousuario/index', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/grupousuario/create', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/grupousuario/edit/{idgrupousuario}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/grupousuario/show/{idgrupousuario}', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/usuario/index', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/usuario/create', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/usuario/edit/{idusuario}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/usuario/show/{idusuario}', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/usuario/asignar', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/formulario/asignar', [App\Http\Controllers\HomeController::class, 'index']);

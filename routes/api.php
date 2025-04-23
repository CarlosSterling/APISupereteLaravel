<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;



#Route::resource('categorias', CategoriaController::class);
#Route::apiResource('usuarios', UsuariosController::class);

Route::apiResource('categorias', 'App\Http\Controllers\CategoriaController');
Route::apiResource('productos', 'App\Http\Controllers\ProductoController');
Route::apiResource('usuarios', 'App\Http\Controllers\UsuariosController');
Route::apiResource('cajaDiaria', 'App\Http\Controllers\CajaDiariaController');
Route::apiResource('detallesCaja', 'App\Http\Controllers\detallesCajaController');
Route::apiResource('transaccion', 'App\Http\Controllers\TransaccionController');


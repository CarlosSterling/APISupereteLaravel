<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


#Route::resource('categorias', CategoriaController::class);

Route::resource('categorias', 'App\Http\Controllers\CategoriaController');
Route::resource('productos', 'App\Http\Controllers\ProductoController');
Route::resource('usuarios', 'App\Http\Controllers\UsuariosController');
Route::resource('cajaDiaria', 'App\Http\Controllers\CajaDiariaController');
Route::Resource('detallesCaja', 'App\Http\Controllers\detallesCajaController');
Route::Resource('transaccion', 'App\Http\Controllers\TransaccionController');

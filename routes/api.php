<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


#Route::resource('categorias', CategoriaController::class);

Route::resource('categorias', 'App\Http\Controllers\CategoriaController');
Route::resource('productos', 'App\Http\Controllers\ProductoController');

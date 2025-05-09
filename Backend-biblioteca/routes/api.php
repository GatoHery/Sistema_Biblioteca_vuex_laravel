<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\proveedorController;
use App\Http\Controllers\autorController;
use App\Http\Controllers\libroController;
use App\Http\Controllers\userController;
use App\Http\Controllers\prestamoController;
use App\Http\Controllers\pedidoController;

Route::apiResource('/categoria', categoriaController::class);
Route::apiResource('/proveedor', proveedorController::class);
Route::apiResource('/autor', autorController::class);
Route::apiResource('/libro', libroController::class);
Route::apiResource('/user', userController::class);
Route::apiResource('/prestamo', prestamoController::class);
Route::apiResource('/pedido', pedidoController::class);
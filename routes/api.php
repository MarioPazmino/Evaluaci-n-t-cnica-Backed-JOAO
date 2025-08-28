<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para CRUD de Clientes
Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index']);                    // Listar clientes (con búsqueda y paginación)
    Route::post('/', [ClienteController::class, 'store']);                   // Crear cliente
    Route::put('/{cliente}', [ClienteController::class, 'update']);          // Actualizar cliente
    Route::delete('/{cliente}', [ClienteController::class, 'destroy']);      // Eliminar cliente
    Route::get('/check-email/{email}', [ClienteController::class, 'checkEmail']); // Verificar si email existe
});

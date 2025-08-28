<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para CRUD de Clientes
Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index']);                   
    Route::post('/', [ClienteController::class, 'store']);                   
    Route::put('/{cliente}', [ClienteController::class, 'update']);        
    Route::delete('/{cliente}', [ClienteController::class, 'destroy']);     
    Route::get('/check-email/{email}', [ClienteController::class, 'checkEmail']); 
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ServicioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ExternoController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [PasswordResetController::class, 'forgot']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);


// Públicas
Route::get('/servicios', [ServicioController::class, 'index']);
Route::get('/servicios/{servicio}', [ServicioController::class, 'show']);
Route::get('/externo/dolar', [ExternoController::class, 'dolar']);

// Protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reportes/clientes', [ReporteController::class, 'clientes']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', fn (Request $request) => $request->user());
    Route::apiResource('clientes', ClienteController::class);
    Route::put('/user', [AuthController::class, 'actualizarPerfil']);
    Route::put('/user/password', [AuthController::class, 'cambiarPassword']);
    Route::get('/admin/servicios', [ServicioController::class, 'todos']);
    Route::apiResource('servicios', ServicioController::class)->except(['index', 'show']);
    Route::post('/servicios/{servicio}/imagen', [ServicioController::class, 'subirImagen']);
    Route::post('/clientes/{cliente}/logo', [ClienteController::class, 'subirLogo']);
});
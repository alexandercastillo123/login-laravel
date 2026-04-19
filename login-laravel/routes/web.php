<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::view('/', 'login');
Route::view('/recuperar', 'recuperar');
Route::view('/restablecer', 'restablecer');
Route::get('/home', function () {return view('home');});
Route::get('/perfil', function () {return view('perfil');});

Route::prefix('api')->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'listar']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'obtenerPorId']);
    Route::post('/registro', [UsuarioController::class, 'registrar']);
    Route::post('/login', [UsuarioController::class, 'login']);
    Route::put('/actualizar/{id}', [UsuarioController::class, 'actualizar']);
    Route::post('/recuperar-codigo', [UsuarioController::class, 'generarCodigo']);
    Route::post('/restablecer-pass', [UsuarioController::class, 'restablecer']);
    Route::get('/perfil', [UsuarioController::class, 'obtenerPerfil']);
    Route::post('/cerrar_sesion', [UsuarioController::class, 'cerrar_sesion']);
});

Route::get('/auth/google', [UsuarioController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [UsuarioController::class, 'handleGoogleCallback']);

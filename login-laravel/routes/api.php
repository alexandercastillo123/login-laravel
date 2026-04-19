<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/usuarios', [UsuarioController::class, 'listar']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'obtenerPorId']);
Route::post('/registro', [UsuarioController::class, 'registrar']);
Route::post('/login', [UsuarioController::class, 'login']);
Route::put('/actualizar/{id}', [UsuarioController::class, 'actualizar']);
Route::post('/recuperar-codigo', [UsuarioController::class, 'generarCodigo']);
Route::post('/restablecer-pass', [UsuarioController::class, 'restablecer']);
Route::get('/perfil', [UsuarioController::class, 'obtenerPerfil']);
Route::post('/cerrar_sesion', [UsuarioController::class, 'cerrar_sesion']);

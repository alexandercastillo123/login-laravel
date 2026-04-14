<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'login');
Route::view('/recuperar', 'recuperar');
Route::view('/restablecer', 'restablecer');
Route::get('/home', function () {return view('home');});

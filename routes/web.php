<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FuncionarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cadastro_funcionario', [UsuarioController::class, 'cadastro_html'])->name('cadastro_funcionario');
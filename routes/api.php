<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/cadastrar_usuarios', [UsuarioController::class, 'cadastrar_usuarios']);

Route::get('/ver_usuarios', [UsuarioController::class, 'ver_usuarios']);

Route::get('/listar_usuarios', [UsuarioController::class, 'listar_usuarios']);

Route::get('/listar_usuarios_simples', [UsuarioController::class, 'listar_usuarios_simples']);

Route::put('/alterar_usuarios', [UsuarioController::class, 'alterar_usuarios']);

Route::delete('/deletar_usuarios', [UsuarioController::class, 'deletar_usuarios']);



Route::get('/cadastrar_funcionarios', [FuncionarioController::class, 'cadastrar_funcionarios_html']);

Route::post('/ver_funcionarios', [FuncionarioController::class, 'ver_funcionarios']);

Route::get('/listar_funcionarios', [FuncionarioController::class, 'listar_funcionarios']);

Route::get('/listar_funcionarios_simples', [FuncionarioController::class, 'listar_funcionarios_simples']);

Route::put('/alterar_funcionarios', [FuncionarioController::class, 'alterar_funcionarios']);

Route::delete('/deletar_funcionarios', [FuncionarioController::class, 'deletar_funcionarios']);



Route::get('/cadastrar_produtos', [ProdutosController::class, 'cadastrar_produtos_html']);

Route::post('/ver_produtos', [ProdutosController::class, 'ver_produtos']);

Route::get('/listar_produtos', [ProdutosController::class, 'listar_produtos']);

Route::get('/listar_produtos_simples', [ProdutosController::class, 'listar_produtos_simples']);

Route::put('/alterar_produtos', [ProdutosController::class, 'alterar_produtos']);

Route::delete('/deletar_produtos', [ProdutosController::class, 'deletar_produtos']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriptomoedasController;

//rotas para visualizar os registros
Route::get('/',function(){return response()->json(['Sucesso'=>true]);});
Route::get('/cripto',[CriptomoedasController::class,'index']);
Route::get('/cripto/{codigo}',[CriptomoedasController::class,'show']);

//rota para inserir os registros
Route::post('/cripto',[CriptomoedasController::class,'store']);

//rota para alterar os registros
Route::put('/cripto/{codigo}',[CriptomoedasController::class,'update']);

//rota para excluir o registro por id/codigo
Route::delete('/cripto/{id}',[CriptomoedasController::class,'destroy']);


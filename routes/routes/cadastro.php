<?php

use App\Http\Controllers\Cadastro\Aluno\AlunoController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum', 'prefix' => '/cadastro'], function () {
    Route::group(['prefix' => '/alunos'], function () {
        Route::post('/data', [AlunoController::class, 'data']);
    });
    Route::resource('/alunos', AlunoController::class);
});


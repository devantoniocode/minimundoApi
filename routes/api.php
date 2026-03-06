<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['jwt.auth'])->group(function () {
    
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::prefix('/projects')->group(function () {
        Route::get('/show_tasks', [ProjectController::class, 'showTasks']);

        Route::post('/data', [ProjectController::class, 'data']);
        Route::post('/edit/{id}', [ProjectController::class, 'edit']);
        Route::post('/update', [ProjectController::class, 'update']);
        Route::post('/destroy/{id}', [ProjectController::class, 'destroy']);
    });
    Route::resource('/projects', ProjectController::class);

    Route::prefix('/tasks')->group(function () {
        Route::post('/data', [TaskController::class, 'data']);
        Route::post('/edit/{id}', [TaskController::class, 'edit']);
        Route::post('/update', [TaskController::class, 'update']);
        Route::post('/destroy/{id}', [TaskController::class, 'destroy']);
    });
    Route::resource('/tasks', TaskController::class);
});

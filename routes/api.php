<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {  
    Route::get('/todos', [TasksController::class, 'index']);
    Route::post('/todos', [TasksController::class, 'create']);
    Route::get('/todos/{task}', [TasksController::class, 'show']);
    Route::put('/todos/{task}', [TasksController::class, 'update']);
    Route::delete('/todos/{task}', [TasksController::class, 'destroy']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

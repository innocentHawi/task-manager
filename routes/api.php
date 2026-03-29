<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('tasks')->group(function () {
    Route::get('report', [TaskController::class, 'report']);
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::patch('{id}/status', [TaskController::class, 'updateStatus']);
    Route::delete('{id}', [TaskController::class, 'destroy']);
});

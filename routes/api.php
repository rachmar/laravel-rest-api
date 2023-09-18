<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TaskTagController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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


Route::prefix('v1')->group(function () 
{
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => ['auth:api', 'task.permission']], function() {

        Route::post('tasks/{task}/tags', [TaskController::class, 'taskTagged']);
        Route::post('tasks/{task}/complete', [TaskController::class, 'taskCompleted']);
        Route::post('tasks/{task}/document', [TaskController::class, 'taskDocument']);
        Route::post('tasks/{task}/deadline', [TaskController::class, 'taskDeadline']);
        Route::post('tasks/{task}/archive', [TaskController::class, 'taskArchived']);

        Route::apiResource('tasks', TaskController::class);

        Route::get('task-tags', [TaskTagController::class, 'index']);

    });

});


// add to check and pay attention the sql queries
// this is just my habit.
DB::listen(function($sql) {
    Log::info($sql->sql);
    Log::info($sql->bindings);
    Log::info($sql->time);
});
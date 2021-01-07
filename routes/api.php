<?php

use App\Http\Controllers\AuthConntroller;
use App\Http\Controllers\TasksController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/register', [AuthConntroller::class, 'store']);
Route::post('user/login', [AuthConntroller::class, 'login']);

Route::group(['middleware'=> ['auth:sanctum']], function (){
    
    Route::post('logout', [AuthConntroller::class, 'logout']);

    //tasks endpoints
    Route::post('tasks/add', [TasksController::class, 'store']);
    Route::patch('tasks/{task}', [TasksController::class, 'update']);
    Route::delete('tasks/{task}', [TasksController::class, 'destroy']);
    Route::get('tasks', [TasksController::class, 'index']);
    
});
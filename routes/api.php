<?php
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LinkController;

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

    Route::post('register',[UserController::class, 'register']);
    Route::post('login',[UserController::class, 'login']);
    // Route::get('survey/{id}',[PostController::class, 'show']);
    Route::post('responses',[ParticipantController::class, 'response']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::delete('logout',[UserController::class, 'logout']);
    Route::get('userData',[UserController::class, 'userData']);
    Route::put('update',[UserController::class, 'update']);

    // Route::apiResource('survey',PostController::class);
    Route::get('survey/count',[PostController::class, 'count']);
    Route::get('survey',[PostController::class, 'index']);
    Route::post('survey',[PostController::class, 'store']);
    // Route::apiResource('question', QuestionController::class);
}); 
    



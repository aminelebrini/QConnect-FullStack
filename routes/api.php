<?php

use App\Http\Controllers\AdminDashController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/questions', [QuestionController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/questions', [QuestionController::class, 'Question']);
    Route::post('/responses', [ReponseController::class, 'Reponse']);
    Route::post('/send', [FavorisController::class, 'favoris']);
    Route::get('get',[FavorisController::class, 'index']);
    Route::get('/Admin', [AdminDashController::class, 'index']);
    Route::post('/Home', [AuthController::class, 'logout']);
    

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

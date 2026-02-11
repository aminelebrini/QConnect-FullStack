<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/questions', [QuestionController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/questions', [QuestionController::class, 'Question']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

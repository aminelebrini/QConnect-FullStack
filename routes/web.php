<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'Show'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'Show'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/', function () {
    return redirect()->route('home');
});

// Routes protégées par auth
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/affichage', [QuestionController::class, 'index'])->name('affichage');

    Route::post('/createQuestion', [QuestionController::class, 'Question'])->name('questions');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

<?php

use App\Http\Controllers\AdminDashController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\FavorisController;
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

    Route::get('/admindash', [AdminDashController::class, 'index'])->name('admindash');

    Route::post('/createQuestion', [QuestionController::class, 'Question'])->name('questions');
    Route::post('/Reponse', [ReponseController::class, 'Reponse'])->name('reponses.store');
    Route::post('/Favoris', [QuestionController::class, 'Favoris'])->name('favoris.store');
    Route::post('/favoris/delete', [FavorisController::class, 'delete'])->name('favoris.delete');
    Route::post('/question/delete', [QuestionController::class, 'deletequestion'])->name('question.delete');
    Route::post('/question/update', [QuestionController::class, 'update'])->name('question.update');


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

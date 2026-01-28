<?php

use App\Http\Controllers\AffichageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'Show'])->name('login');
Route::get('/register', [AuthController::class, 'Show'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');

Route::get('/', function () {
    return redirect('/home');

    Route::get('/affichage', [AffichageController::class, 'index'])->name('affichage.index');
});


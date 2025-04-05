<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthViewsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthViewsController::class, 'login'])->name('login');
    Route::get('/register', [AuthViewsController::class, 'register'])->name('register');

    Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
    Route::post('/register', [AuthController::class, 'registerUser'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

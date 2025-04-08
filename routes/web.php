<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return Inertia::render('RegistrationForm');
    });
    Route::post('registerUser', [AuthController::class, 'registerUser'])->name('registerUser');
});


Route::middleware('auth')->group(function () {
    Route::get('/stockData', [StockController::class, 'stockData'])->name('stockData');
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::post('/updateStockRate', [StockController::class, 'updateStockRate'])->name('updateStockRate');


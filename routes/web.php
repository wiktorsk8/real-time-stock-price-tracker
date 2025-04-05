<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('RegistrationForm');
});

Route::middleware('auth')->group(function () {
    Route::get('/stockData', [StockController::class, 'stockData'])->name('stockData');
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::post('/updateStockRate', [StockController::class, 'updateStockRate'])->name('updateStockRate');

require __DIR__.'/auth.php';

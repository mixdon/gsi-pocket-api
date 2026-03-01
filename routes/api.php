<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PocketController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('jwt.auth')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('pockets')->group(function () {
        Route::get('/', [PocketController::class, 'index']);
        Route::post('/', [PocketController::class, 'store']);
        Route::get('/total-balance', [PocketController::class, 'totalBalance']);
        Route::post('/{id}/create-report', [ReportController::class, 'create'])
            ->whereUuid('id');
    });

    Route::post('/incomes', [IncomeController::class, 'store']);
    Route::post('/expenses', [ExpenseController::class, 'store']);
});
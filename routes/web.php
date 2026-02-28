<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Pockets
    Route::get('pockets', [PocketController::class, 'index']);
    Route::post('pockets', [PocketController::class, 'store']);
    Route::get('pockets/total-balance', [PocketController::class, 'totalBalance']);

    // Transactions
    Route::post('incomes', [IncomeController::class, 'store']);
    Route::post('expenses', [ExpenseController::class, 'store']);
});
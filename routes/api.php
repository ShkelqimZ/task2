<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;

Route::get('/books', BookController::class);

Route::group(['prefix' => "loans"], function () {
    Route::post('/', [LoanController::class, 'store']);
    Route::post('/{loan}/return', [LoanController::class, 'returnBook']);
});

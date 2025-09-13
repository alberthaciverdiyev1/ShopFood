<?php

use App\Http\Controllers\BasketController;

Route::controller(BasketController::class)->middleware('auth')->prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'basket'])->name('basket.list');
    Route::post('/add/{productId}', [BasketController::class, 'add'])->name('basket.add');
    Route::post('/update/{productId}', [BasketController::class, 'updateQuantity'])->name('basket.update');
    Route::post('/remove/{productId}', [BasketController::class, 'delete'])->name('basket.remove');
});

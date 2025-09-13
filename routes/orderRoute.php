<?php

use App\Http\Controllers\OrderController;

Route::controller(OrderController::class)->middleware('auth')->prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'list'])->name('order.list');
    Route::get('/list/ajax', [OrderController::class, 'listAjax'])->name('order.list.ajax');
    Route::post('/', [OrderController::class, 'add'])->name('order.add');
    Route::put('/{order}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/{order}', [OrderController::class, 'delete'])->name('order.delete');
});

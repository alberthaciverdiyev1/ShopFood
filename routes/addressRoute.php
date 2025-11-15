<?php

use App\Http\Controllers\AddressController;

Route::middleware('auth')->group(function () {
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'add']);
    Route::put('/addresses/{id}', [AddressController::class, 'edit']);
    Route::delete('/addresses/{id}', [AddressController::class, 'delete']);
});

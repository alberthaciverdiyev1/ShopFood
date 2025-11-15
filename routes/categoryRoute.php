<?php

use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin/category')
    // ->middleware('auth')
    ->name('category.')
    ->group(function () {
        Route::get('/', [CategoryController::class, 'getAll'])->name('list');
        Route::post('/', [CategoryController::class, 'store'])->name('add');
        Route::get('/add', [CategoryController::class, 'create'])->name('create');
        Route::get('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::put('/{category}', [CategoryController::class, 'edit'])->name('edit');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('delete');
    });

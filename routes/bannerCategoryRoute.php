<?php

use App\Http\Controllers\Admin\BannerCategoryController;

Route::prefix('admin/banner-category')
    // ->middleware('auth')
    ->name('bannerCategory.')
    ->group(function () {
        Route::get('/', [BannerCategoryController::class, 'getAll'])->name('list');
        Route::post('/', [BannerCategoryController::class, 'store'])->name('add');
        Route::put('/{category}', [BannerCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [BannerCategoryController::class, 'destroy'])->name('delete');
    });

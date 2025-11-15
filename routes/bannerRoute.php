<?php
use App\Http\Controllers\BannerController;


Route::prefix('banners')->name('banners.')->group(function () {
    Route::get('/', [BannerController::class, 'list'])->name('index');
    Route::post('/', [BannerController::class, 'add'])->name('store');
    Route::put('/{banner}', [BannerController::class, 'edit'])->name('update');
    Route::delete('/{banner}', [BannerController::class, 'delete'])->name('destroy');
});

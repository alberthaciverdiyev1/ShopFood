<?php

use App\Http\Controllers\Admin\TagController;

Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
Route::get('/tags', [TagController::class, 'list'])->name('tags.list');
Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

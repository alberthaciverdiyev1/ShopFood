<?php

use App\Http\Controllers\Admin\TagController;

Route::post('/tags', [TagController::class, 'store'])->name('tags.store')->middleware('admin');
Route::get('/tags', [TagController::class, 'list'])->name('tags.list');
Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update')->middleware('admin');
Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy')->middleware('admin');

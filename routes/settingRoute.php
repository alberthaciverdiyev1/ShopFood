<?php
use App\Http\Controllers\Admin\SettingController;

Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('setting', [SettingController::class, 'update'])->name('setting.update');


<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\UsersInfoController;
use App\Http\Controllers\AuthController;

Route::get('/users', [UsersController::class, 'index'])->name('admin.users');
Route::post('/users/delete/{id}', [UsersController::class, 'delete'])->name('users.delete');

//Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {


// User edit & update
Route::put('/users/{user}', [UsersController::class, 'update'])->name('admin.users.update');

Route::post('/users/toggle/{user}', [UsersController::class, 'toggle'])->name('admin.users.toggle');

// Forgot password
Route::post('/users/forgot-password/{id}', [UsersController::class, 'forgotPassword'])->name('admin.users.forgot-password');
Route::get('/password-reset/{token}', [UsersController::class, 'showResetForm'])->name('password.reset');
Route::post('/password-reset', [UsersController::class, 'resetPassword'])->name('password.update');

//});


Route::post('/users/toggle/{user}', [UsersController::class, 'toggle'])->name('admin.users.toggle');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/users-info/edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
Route::get('/users-info', [UsersController::class, 'index'])->name('users.index');
Route::get('/users-info/{id}', [UsersController::class, 'show'])->name('user.details');

Route::post('/user/confirm/{id}', [UsersController::class, 'confirmUser'])->name('admin.users.confirm');

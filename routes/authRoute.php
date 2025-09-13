<?php

use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');

    Route::get('/register', 'register')->name('web:register');
    Route::post('/register', 'register')->name('register');
    Route::get('/profile', 'profile')->name('profile')->middleware('auth');
});

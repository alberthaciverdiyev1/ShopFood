<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/welcome',[HomeController::class,'welcome']);

Route::get('/register',[UserController::class,'register'])->name('register');
Route::get('/login',[UserController::class,'login'])->name('login');


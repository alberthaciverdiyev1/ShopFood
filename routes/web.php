<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\PrivacyPolicyController;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\CategoryController;

Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index']);
Route::post('/privacy-policy', [PrivacyPolicyController::class, 'update']);
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/welcome',[HomeController::class,'welcome'])->name('welcome');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::resource('exchange-rates', ExchangeRateController::class);

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/tags', [TagController::class, 'store']);
Route::get('users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
Route::put('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
Route::get('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');

// Endirim düyməsi üçün
Route::post('users/{user}/apply-discount', [App\Http\Controllers\Admin\UserController::class, 'applyDiscount'])->name('admin.users.applyDiscount');

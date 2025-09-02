<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', action: [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/list', action: [ListController::class, 'list'])->name('list')->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth')->middleware(LocaleMiddleware::class);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/welcome',[HomeController::class,'welcome'])->name('welcome');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('change-locale', [\App\Http\Controllers\BaseController::class,'changeLocale'])->name('change-locale');


Route::get('/test', [\App\Http\Controllers\TestController::class, 'index'])->name('test.index');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');



Route::get('/basket', [BasketController::class, 'basket'])->name('basket');


Route::get('/register', [RegisterController::class, 'showForm'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
Route::post('/admin/users/{user}/toggle', [UserController::class, 'toggle'])->name('admin.users.toggle');


Route::get('/activate/{id}', function($id) { $user = \App\Models\User::findOrFail($id);
    $user->update(['is_active' => 1, 'is_send_email' => 2]); // 2 → aktivləşdirildi
    return "Hesab aktivləşdirildi!";
});

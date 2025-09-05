<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Controllers\{AuthController,
    HomeController,
    ListController,
    TagController,
    UserController,
    RegisterController,
    ExchangeRateController,
    BasketController};

Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index']);
Route::post('/privacy-policy', [PrivacyPolicyController::class, 'update']);
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
// Locale + Home
Route::middleware([LocaleMiddleware::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])
        ->name('home')
        ->middleware('auth');

    Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');
    Route::post('change-locale', [\App\Http\Controllers\BaseController::class, 'changeLocale'])
        ->name('change-locale');
});

// Authentication & Profile
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');

    Route::get('/register', 'register')->name('web:register');
    Route::post('/register', 'register')->name('register');

    Route::get('/profile', 'profile')->name('profile')->middleware('auth');
});

// List & Basket
Route::get('/list', [ListController::class, 'list'])->name('list')->middleware('auth');
Route::get('/basket', [BasketController::class, 'basket'])->name('basket');

// Exchange Rates
Route::resource('exchange-rates', ExchangeRateController::class);

Route::get('/register', [AuthController::class, 'register'])->name('web:register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/tags', [TagController::class, 'store']);
//  Test
Route::get('/test', [\App\Http\Controllers\TestController::class, 'index'])->name('test.index');

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/users/{user}/toggle', [UserController::class, 'toggle'])->name('admin.users.toggle');
});

// Activation
Route::get('/activate/{id}', function ($id) {
    $user = \App\Models\User::findOrFail($id);
    $user->update(['is_active' => 1, 'is_send_email' => 2]); // 2 → aktivləşdirildi
    return "Hesab aktivləşdirildi!";
});

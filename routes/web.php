<?php

use App\Http\Controllers\Admin\UsersInfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrivacyPolicyController;

//use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Middleware\LocaleMiddleware;

use App\Http\Controllers\{AuthController,
    FavoriteController,
    HomeController,
    ListController,
    OrderController,
    TagController,
    UserController,
    RegisterController,
    ExchangeRateController,
    BasketController};
use App\Http\Controllers\Admin\DashboardController;

//Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
//Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

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

Route::controller(BasketController::class)->middleware('auth')->prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'basket'])->name('basket.list');
    Route::post('/add/{productId}', [BasketController::class, 'add'])->name('basket.add');
    Route::post('/update/{productId}', [BasketController::class, 'updateQuantity'])->name('basket.update');
    Route::post('/remove/{productId}', [BasketController::class, 'delete'])->name('basket.remove');
});

Route::controller(OrderController::class)->middleware('auth')->prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'list'])->name('order.list');
    Route::get('/list/ajax', [OrderController::class, 'listAjax'])->name('order.list.ajax');
    Route::post('/', [OrderController::class, 'add'])->name('order.add');
    Route::put('/{order}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/{order}', [OrderController::class, 'delete'])->name('order.delete');
});

// Exchange Rates
Route::resource('exchange-rates', ExchangeRateController::class);

Route::get('/register', [AuthController::class, 'register'])->name('web:register');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::post('/tags', [TagController::class, 'store']);
Route::get('users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
Route::put('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
Route::get('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');

// Endirim düyməsi üçün
Route::post('users/{user}/apply-discount', [App\Http\Controllers\Admin\UserController::class, 'applyDiscount'])->name('admin.users.applyDiscount');
Route::get('/tags', [TagController::class, 'list']);
//  Test
Route::get('/test', [\App\Http\Controllers\TestController::class, 'index'])->name('test.index');

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin');
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/users', [UsersController::class, 'index'])->name('admin.users');
    Route::post('/users/toggle/{user}', [UsersController::class, 'toggle'])->name('admin.users.toggle');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users-info', [UsersInfoController::class, 'index'])->name('users.index');
    Route::get('/order', [\App\Http\Controllers\Admin\AdminOrderController::class, 'adminList'])->name('admin.order');
    Route::post('/order/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'update'])->name('admin.order.update');

});


Route::prefix('admin')->prefix('favorites')->middleware('auth')->group(function () {
    Route::get('/', [FavoriteController::class, 'list'])->name('favorites.list');
    Route::get('/list/ajax', [FavoriteController::class, 'listAjax'])->name('favorites.list.ajax');
    Route::post('/add/{productId}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/delete/{productId}', [FavoriteController::class, 'delete'])->name('favorites.delete');
});
// Activation
Route::get('/activate/{id}', function ($id) {
    $user = \App\Models\User::findOrFail($id);
    $user->update(['is_active' => 1, 'is_send_email' => 2]); // 2 → aktivləşdirildi
    return "Hesab aktivləşdirildi!";
});

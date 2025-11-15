<?php

use App\Http\Controllers\{Admin\ExchangeRateController,
    Admin\TagController,
    AuthController,
    BasketController,
    FavoriteController,
    HomeController,
    ListController,
    OrderController,
    RegisterController
};
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\UsersInfoController;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\CategoryController;

//Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
//Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');


Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
// Locale + Home
Route::middleware([LocaleMiddleware::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])
        ->name('home')
        ->middleware('auth');

    Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');
    Route::post('change-locale', [\App\Http\Controllers\BaseController::class, 'changeLocale'])->name('change-locale');
});
Route::get('/list', [ListController::class, 'list'])->name('list')->middleware('auth');
Route::get('/start-queue', [\App\Http\Controllers\BaseController::class, 'startQueue'])->name('start-queue');
Route::get('/start-stock-queue', [\App\Http\Controllers\BaseController::class, 'startStockQueue'])->name('start-stock-queue');
// Authentication & Profile
require 'authRoute.php';
require 'basketRoute.php';
require 'orderRoute.php';
require 'tagRoute.php';
require 'currencyRoute.php';
require 'settingRoute.php';
require 'addressRoute.php';
require 'bannerRoute.php';
require 'bannerCategoryRoute.php';
require 'categoryRoute.php';
require 'tradingRulesRoute.php';


Route::post('/users/{id}', [AuthController::class, 'update'])->name('profile.update');

Route::post('users/{user}/apply-discount', [App\Http\Controllers\Admin\UserController::class, 'applyDiscount'])->name('admin.users.applyDiscount');
//  Test
Route::get('/test', [\App\Http\Controllers\TestController::class, 'index'])->name('test.index');

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin');

    require 'userRoute.php';

    Route::get('/order', [\App\Http\Controllers\Admin\AdminOrderController::class, 'adminList'])->name('admin.order');
    Route::post('/order/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'update'])->name('admin.order.update');

    require 'privacyRoute.php';

});


Route::prefix('admin')->prefix('favorites')->middleware('auth')->group(function () {
    Route::get('/', [FavoriteController::class, 'list'])->name('favorites.list');
    Route::get('/list/ajax', [FavoriteController::class, 'listAjax'])->name('favorites.list.ajax');
    Route::post('/add/{productId}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/delete/{productId}', [FavoriteController::class, 'delete'])->name('favorites.delete');
});

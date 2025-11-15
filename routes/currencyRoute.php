<?php

use App\Http\Controllers\Admin\ExchangeRateController;

Route::get('exchange-rates', [ExchangeRateController::class,'index'])->name('exchange-rates.index');
Route::put('exchange-rates/{id}', [ExchangeRateController::class, 'update'])->name('exchange-rates.update');;

<?php

use App\Http\Controllers\Admin\TradingRulesController;

Route::get('admin/trading-rules', [TradingRulesController::class, 'index'])->name('trading_rules.index');
Route::post('admin/trading-rules', [TradingRulesController::class, 'update'])->name('trading_rules.update');

Route::get('trading-rules', [TradingRulesController::class, 'tradingRulesHome'])->name('trading_rules.home');

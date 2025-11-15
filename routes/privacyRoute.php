<?php

use App\Http\Controllers\Admin\PrivacyPolicyController;

Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
Route::post('privacy-policy', [PrivacyPolicyController::class, 'update'])->name('privacy-policy.update');

Route::get('privacy-and-policy', [PrivacyPolicyController::class, 'privacyPolicyHome'])->name('privacy-policy.home');

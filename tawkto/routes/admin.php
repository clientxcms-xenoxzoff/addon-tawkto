<?php

use App\Addons\Tawkto\Controllers\TawktoAdminController;

Route::get('settings/tawkto', [TawktoAdminController::class, 'showSettings'])->name('settings');
Route::put('settings/tawkto', [TawktoAdminController::class, 'updateSettings'])->name('settings.update');

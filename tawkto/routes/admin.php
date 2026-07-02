<?php

use App\Addons\Tawkto\Controllers\TawktoAdminController;

Route::put('settings/tawkto', [TawktoAdminController::class, 'updateSettings'])->name('settings');

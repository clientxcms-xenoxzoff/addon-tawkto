<?php

use App\Addons\Tawkto\Controllers\TawktoAdminController;
use Illuminate\Support\Facades\Route;

Route::get('tawkto', function () {
    return redirect()->to(admin_prefix() . '/settings/tawkto');
})->name('admin');

Route::put('settings/tawkto', [TawktoAdminController::class, 'updateSettings'])->name('settings');

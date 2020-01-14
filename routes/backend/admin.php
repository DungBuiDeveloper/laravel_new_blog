<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('media', 'MediaLibraryController')->only(['index', 'show', 'create', 'store', 'destroy']);

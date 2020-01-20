<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MediaLibraryController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('media', 'MediaLibraryController')->only(['index', 'show', 'create', 'store', 'destroy']);
Route::post('media/ajaxData', [MediaLibraryController::class, 'ajaxDataTable'])->name('media.ajax');
Route::post('media/storeOnlyImage', [MediaLibraryController::class, 'storeOnlyImage'])->name('media.imageOnly');
Route::post('media/storeCkEditor', [MediaLibraryController::class, 'storeCkEditor'])->name('media.storeCkEditor');

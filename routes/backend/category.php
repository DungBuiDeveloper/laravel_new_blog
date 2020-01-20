<?php

use App\Http\Controllers\Backend\PostBlog\CategoriesController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('categories', [CategoriesController::class, 'index'])->name('categories.list');
Route::get('categories/{slug}/detail', [CategoriesController::class, 'detail'])->name('categories.detail');
Route::get('categories/store', [CategoriesController::class, 'showFormAdd'])->name('categories.showFormAdd');
Route::get('categories/{slug}/edit', [CategoriesController::class, 'showFormEdit'])->name('categories.showFormEdit');
Route::post('categories/add', [CategoriesController::class, 'storeCategory'])->name('categories.add');
Route::post('categories/edit', [CategoriesController::class, 'editCategory'])->name('categories.edit');
Route::delete('categories/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');
Route::post('categories/ajaxData', [CategoriesController::class, 'ajaxDataTable'])->name('categories.ajax');

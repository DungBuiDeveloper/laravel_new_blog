<?php

use App\Http\Controllers\Backend\PostBlog\TagsController;

// All route names are prefixed with 'admin.'.
Route::get('tags', [TagsController::class, 'index'])->name('tags.list');
Route::get('tags/{slug}/detail', [TagsController::class, 'detail'])->name('tags.detail');
Route::get('tags/store', [TagsController::class, 'showFormAdd'])->name('tags.showFormAdd');
Route::get('tags/{slug}/edit', [TagsController::class, 'showFormEdit'])->name('tags.showFormEdit');
Route::post('tags/add', [TagsController::class, 'storeTag'])->name('tags.add');
Route::post('tags/edit', [TagsController::class, 'editTag'])->name('tags.edit');
Route::delete('tags/destroy', [TagsController::class, 'destroy'])->name('tags.destroy');
Route::post('tags/ajaxData', [TagsController::class, 'ajaxDataTable'])->name('tags.ajax');

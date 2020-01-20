<?php

use App\Http\Controllers\Backend\PostBlog\PostsController;

// All route names are prefixed with 'admin.'.
Route::get('posts', [PostsController::class, 'index'])->name('posts.list');
Route::get('posts/{slug}/detail', [PostsController::class, 'detail'])->name('posts.detail');
Route::get('posts/store', [PostsController::class, 'showFormAdd'])->name('posts.showFormAdd');
Route::get('posts/{slug}/edit', [PostsController::class, 'showFormEdit'])->name('posts.showFormEdit');
Route::post('posts/add', [PostsController::class, 'storePost'])->name('posts.add');
Route::post('posts/edit', [PostsController::class, 'editPost'])->name('posts.edit');
Route::delete('posts/destroy', [PostsController::class, 'destroy'])->name('posts.destroy');
Route::post('posts/ajaxData', [PostsController::class, 'ajaxDataTable'])->name('posts.ajax');

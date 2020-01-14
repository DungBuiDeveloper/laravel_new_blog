<?php

Breadcrumbs::for('admin.media.index', function ($trail) {
    $trail->push(__('labels.backend.access.media.management'), route('admin.media.index'));
});

Breadcrumbs::for('admin.media.create', function ($trail) {
    $trail->parent('admin.media.index');
    $trail->push(__('labels.backend.access.media.create'), route('admin.media.create'));
});
//
// Breadcrumbs::for('admin.categories.showFormEdit', function ($trail, $slug) {
//     $trail->parent('admin.categories.list');
//     $trail->push(__('menus.backend.access.category.create'), route('admin.categories.showFormEdit', $slug));
// });
//
// Breadcrumbs::for('admin.categories.detail', function ($trail, $slug) {
//     $trail->parent('admin.categories.list');
//     $trail->push(__('menus.backend.access.category.edit'), route('admin.categories.detail', $slug));
// });

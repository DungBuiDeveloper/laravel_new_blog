<?php

Breadcrumbs::for('admin.categories.list', function ($trail) {
    $trail->push(__('labels.backend.access.category.management'), route('admin.categories.list'));
});

Breadcrumbs::for('admin.categories.showFormAdd', function ($trail) {
    $trail->parent('admin.categories.list');
    $trail->push(__('menus.backend.access.category.create'), route('admin.categories.showFormAdd'));
});

Breadcrumbs::for('admin.categories.showFormEdit', function ($trail, $slug) {
    $trail->parent('admin.categories.list');
    $trail->push(__('menus.backend.access.category.edit'), route('admin.categories.showFormEdit', $slug));
});

Breadcrumbs::for('admin.categories.detail', function ($trail, $slug) {
    $trail->parent('admin.categories.list');
    $trail->push(__('menus.backend.access.category.edit'), route('admin.categories.detail', $slug));
});

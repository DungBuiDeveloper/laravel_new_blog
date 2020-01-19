<?php

Breadcrumbs::for('admin.tags.list', function ($trail) {
    $trail->push(__('labels.backend.access.tag.management'), route('admin.tags.list'));
});

Breadcrumbs::for('admin.tags.showFormAdd', function ($trail) {
    $trail->parent('admin.tags.list');
    $trail->push(__('menus.backend.access.tag.create'), route('admin.tags.showFormAdd'));
});

Breadcrumbs::for('admin.tags.showFormEdit', function ($trail, $slug) {
    $trail->parent('admin.tags.list');
    $trail->push(__('menus.backend.access.tag.edit'), route('admin.tags.showFormEdit', $slug));
});

Breadcrumbs::for('admin.tags.detail', function ($trail, $slug) {
    $trail->parent('admin.tags.list');
    $trail->push(__('menus.backend.access.tag.edit'), route('admin.tags.detail', $slug));
});

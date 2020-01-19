<?php

Breadcrumbs::for('admin.posts.list', function ($trail) {
    $trail->push(__('labels.backend.access.post.management'), route('admin.posts.list'));
});

Breadcrumbs::for('admin.posts.showFormAdd', function ($trail) {
    $trail->parent('admin.posts.list');
    $trail->push(__('menus.backend.access.post.create'), route('admin.posts.showFormAdd'));
});

Breadcrumbs::for('admin.posts.showFormEdit', function ($trail, $slug) {
    $trail->parent('admin.posts.list');
    $trail->push(__('menus.backend.access.post.edit'), route('admin.posts.showFormEdit', $slug));
});

Breadcrumbs::for('admin.posts.detail', function ($trail, $slug) {
    $trail->parent('admin.posts.list');
    $trail->push(__('menus.backend.access.post.edit'), route('admin.posts.detail', $slug));
});

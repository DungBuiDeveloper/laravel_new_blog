<?php

Breadcrumbs::for('admin.categories.list', function ($trail) {
    $trail->push(__('labels.backend.access.users.management'), route('admin.categories.list'));
});

Breadcrumbs::for('admin.categories.showFormAdd', function ($trail) {
    $trail->parent('admin.categories.list');
    $trail->push(__('menus.backend.access.users.deactivated'), route('admin.categories.showFormAdd'));
});

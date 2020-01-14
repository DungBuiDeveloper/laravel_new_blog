<?php

namespace App\Http\Composers\Backend;

use Illuminate\View\View;

/**
 * Class SidebarComposer.
 */
class MenuComposer
{
    /**
     * @param View $view
     *
     * @return array Menu
     */
    public function compose(View $view)
    {
        $menu = [
            'general' => [
                [
                    'name' => __('menus.backend.sidebar.dashboard'),
                    'link' => route('admin.dashboard'),
                    'active' => \Route::is('admin/dashboard'),
                    'icon' => '<i class="nav-icon fas fa-tachometer-alt"></i>',
                    'child' => null,
                ],
                [
                    'name' => __('menus.backend.sidebar.categories'),
                    'link' => route('admin.categories.list'),
                    'active' => \Request::is('admin/categories/*'),
                    'icon' => '<i class="nav-icon fas fa-book"></i>',
                    'child' => null,
                ],
                [
                    'name' => __('menus.backend.sidebar.media'),
                    'link' => route('admin.media.index'),
                    'active' => \Request::is('admin/media/*'),
                    'icon' => '<i class="nav-icon fas fa-photo-video"></i>',
                    'child' => null,
                ],
            ],
            'admin' => [],
        ];

        $view->with('menu_sidebar', $menu);
    }
}

<?php

namespace WpPluginner\Wordpress\Hook;

use WpPluginner\Lumen\Application;
use WpPluginner\Illuminate\Support\Str;

class AdminMenu extends Hook
{
    public $menus;
    public $subMenus;

	public function add(
		string $page_title,
		string $menu_title,
		string $capability,
		string $menu_slug,
		$controller,
		string $icon_url = '',
		int $position = null
	) {
		$controller = $this->handleController($controller);
        $this->menus[] = compact('page_title', 'menu_title', 'capability', 'menu_slug', 'controller', 'icon_url', 'position');
		return $this;
	}

    public function send()
    {
        if (is_array($this->menus) || is_array($this->subMenus)) {
            $menus = $this->menus;
            $subMenus = $this->subMenus;
            $this->app['wp.action']->add('admin_menu', function() use ($menus, $subMenus) {
                if (is_array($menus)) {
                    foreach ($menus as $menu) {
                        extract($menu);
                        add_menu_page(
                            $page_title, $menu_title, $capability, $menu_slug, $controller, $icon_url, $position
                        );
                    }
                }
                if (is_array($subMenus)) {
                    foreach ($subMenus as $subMenu) {
                        extract($subMenu);
                        add_submenu_page(
                            $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $controller
                        );
                    }
                }
			});
        }
    }

	public function addSub(
        string $parent_slug,
		string $page_title,
		string $menu_title,
		string $capability,
		string $menu_slug,
		$controller
	) {
        $controller = $this->handleController($controller);
        $this->subMenus[] = compact('parent_slug', 'page_title', 'menu_title', 'capability', 'menu_slug', 'controller');

		return $this;
	}
}

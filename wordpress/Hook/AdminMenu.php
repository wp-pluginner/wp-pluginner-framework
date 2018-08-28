<?php

namespace WpPluginner\Wordpress\Hook;

use WpPluginner\Illuminate\Support\Arr;

class AdminMenu extends Hook
{
	public function add(array $args, $return = false)
    {
        if (!isset($args['page_title']) && isset($args['menu_title'])) {
            $args['page_title'] = $args['menu_title'];
        }
        if (!isset($args['menu_title']) && isset($args['page_title'])) {
            $args['menu_title'] = $args['page_title'];
        }
        if (isset($args['menu_title']) && isset($args['menu_slug'])) {
            $menu = add_menu_page(
                Arr::get($args, 'page_title', ''),
                Arr::get($args, 'menu_title'),
                Arr::get($args, 'capability', 'manage_options'),
                Arr::get($args, 'menu_slug'),
                $this->handleController(Arr::get($args, 'controller', '')),
                Arr::get($args, 'icon_url', ''),
                Arr::get($args, 'position')
            );
			if ($return) return $menu;
        }


		return $this;
	}

	public function addSub($parent_slug, array $args, $return = false)
    {
        if (!isset($args['page_title']) && isset($args['menu_title'])) {
            $args['page_title'] = $args['menu_title'];
        }
        if (!isset($args['menu_title']) && isset($args['page_title'])) {
            $args['menu_title'] = $args['page_title'];
        }

        if ($parent_slug && isset($args['menu_title']) && isset($args['menu_slug'])) {
            $submenu = add_submenu_page(
                $parent_slug,
                Arr::get($args, 'page_title', ''),
                Arr::get($args, 'menu_title'),
                Arr::get($args, 'capability', 'manage_options'),
                Arr::get($args, 'menu_slug'),
                $this->handleController(Arr::get($args, 'controller', ''))
            );
			if ($return) return $submenu;
        }

		return $this;
	}

    public function send()
    {

    }
}

<?php

namespace WpPluginner\Wordpress\Hook;

use WpPluginner\Lumen\Application;
use WpPluginner\Illuminate\Support\Str;

class Action extends Hook
{
	public function add(string $tag, $controller, int $priority = 10, int $accepted_args = 1)
	{
		$controller = $this->handleController($controller);
		if ($controller) add_action($tag, $controller, $priority, $accepted_args);
		return $this;
	}

	public function do(string $tag)
	{
		if (func_num_args() > 2) {
			$args = func_get_args();
			array_shift( $args );
            return do_action_ref_array($tag, $args);
        } elseif (func_num_args() == 2) {
			$arg = func_get_args(1);
            return do_action($tag, $arg);
        }
        return do_action($tag);
	}

	public function doRefArray(string $tag, array $args)
	{
		return do_action_ref_array($tag, $args);
	}

	public function has(string $tag, $controller = false)
	{
        if ($controller) $controller = $this->handleController($controller);

		return has_action($tag, $controller);
	}

	public function remove(string $tag, $controller, $priority = 10)
	{
        $controller = $this->handleController($controller);

		remove_action($tag, $controller, $priority);
        return $this;
	}

	public function removeAll(string $tag, $priority = false)
	{
		remove_all_actions($tag, $priority);
        return $this;
	}
}

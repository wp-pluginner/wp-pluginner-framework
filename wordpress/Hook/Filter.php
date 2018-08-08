<?php

namespace WpPluginner\Wordpress\Hook;

use WpPluginner\Lumen\Application;
use WpPluginner\Illuminate\Support\Str;

class Filter extends Hook
{
	public function add(string $tag, $controller, int $priority = 10, int $accepted_args = 1)
	{
		$controller = $this->handleController($controller);
		if ($controller) add_filter($tag, $controller, $priority, $accepted_args);
		return $this;
	}

	public function apply(string $tag, $value)
	{
		if (func_num_args() > 2) {
			$args = func_get_args();
			array_shift( $args );
            return apply_filters_ref_array($tag, $args);
        }
        return apply_filters($tag, $value);
	}

	public function applyRefArray(string $tag, array $args)
	{
		return apply_filters_ref_array($tag, $args);
	}

	public function has(string $tag, $controller = false)
	{
        if ($controller) $controller = $this->handleController($controller);

		return has_filter($tag, $controller);
	}

	public function remove(string $tag, $controller, $priority = 10)
	{
        $controller = $this->handleController($controller);

		remove_filter($tag, $controller, $priority);
        return $this;
	}

	public function removeAll(string $tag, $priority = false)
	{
		remove_all_filters($tag, $priority);
        return $this;
	}
}

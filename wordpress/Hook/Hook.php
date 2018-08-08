<?php

namespace WpPluginner\Wordpress\Hook;

use WpPluginner\Lumen\Application;
use WpPluginner\Illuminate\Support\Str;

class Hook
{
    protected $app;

	public function __construct(Application $app){
		$this->app = $app;
	}

	public function handleController($controller)
	{
		if (is_callable($controller)) {
			return $controller;
        } elseif (is_string($controller) && Str::contains($controller, '@')) {
			$app = $this->app;
			return function() use ($app, $controller) {
				if (func_num_args() === 0) {
					return $app->call($controller);
				} else {
					$parameters = func_get_args();
					return $app->call($controller, $parameters);
				}
			};
        }
		return null;
	}
}

<?php

namespace WpPluginner\Wordpress\View\Facades;

use WpPluginner\Illuminate\Support\Facades\Facade;

/**
 * @see WpPluginner\Wordpress\View\Compilers\StringBladeCompiler
 */
class StringBlade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return static::$app['view']->getEngineResolver()->resolve('stringblade')->getCompiler();
    }
}

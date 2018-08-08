<?php

namespace WpPluginner\Illuminate\Support\Facades;

/**
 * @see \WpPluginner\Illuminate\Cache\CacheManager
 * @see \WpPluginner\Illuminate\Cache\Repository
 */
class Cache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cache';
    }
}

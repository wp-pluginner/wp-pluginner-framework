<?php

namespace WpPluginner\Illuminate\Support\Facades;

/**
 * @see \WpPluginner\Illuminate\Redis\RedisManager
 * @see \WpPluginner\Illuminate\Contracts\Redis\Factory
 */
class Redis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }
}

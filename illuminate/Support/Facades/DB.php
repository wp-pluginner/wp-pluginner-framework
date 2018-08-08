<?php

namespace WpPluginner\Illuminate\Support\Facades;

/**
 * @see \WpPluginner\Illuminate\Database\DatabaseManager
 * @see \WpPluginner\Illuminate\Database\Connection
 */
class DB extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}

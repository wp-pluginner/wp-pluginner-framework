<?php

namespace WpPluginner\Illuminate\Support\Facades;

/**
 * @see \WpPluginner\Illuminate\Http\Request
 */
class Request extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'request';
    }
}

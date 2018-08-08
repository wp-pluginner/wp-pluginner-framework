<?php

namespace WpPluginner\Illuminate\Support\Facades;

use WpPluginner\Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

/**
 * @see \WpPluginner\Illuminate\Contracts\Routing\ResponseFactory
 */
class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ResponseFactoryContract::class;
    }
}

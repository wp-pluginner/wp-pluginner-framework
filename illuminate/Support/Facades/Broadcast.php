<?php

namespace WpPluginner\Illuminate\Support\Facades;

use WpPluginner\Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactoryContract;

/**
 * @see \WpPluginner\Illuminate\Contracts\Broadcasting\Factory
 */
class Broadcast extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BroadcastingFactoryContract::class;
    }
}

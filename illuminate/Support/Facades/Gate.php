<?php

namespace WpPluginner\Illuminate\Support\Facades;

use WpPluginner\Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * @see \WpPluginner\Illuminate\Contracts\Auth\Access\Gate
 */
class Gate extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return GateContract::class;
    }
}

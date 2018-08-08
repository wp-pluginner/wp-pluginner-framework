<?php

namespace WpPluginner\Illuminate\Support\Facades;

use WpPluginner\Illuminate\Database\Eloquent\Model;
use WpPluginner\Illuminate\Support\Testing\Fakes\EventFake;

/**
 * @see \WpPluginner\Illuminate\Events\Dispatcher
 */
class Event extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap($fake = new EventFake);

        Model::setEventDispatcher($fake);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'events';
    }
}

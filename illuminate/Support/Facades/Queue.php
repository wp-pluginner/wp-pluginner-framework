<?php

namespace WpPluginner\Illuminate\Support\Facades;

use WpPluginner\Illuminate\Support\Testing\Fakes\QueueFake;

/**
 * @see \WpPluginner\Illuminate\Queue\QueueManager
 * @see \WpPluginner\Illuminate\Queue\Queue
 */
class Queue extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new QueueFake(static::getFacadeApplication()));
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'queue';
    }
}

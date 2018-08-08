<?php

namespace WpPluginner\Illuminate\Support\Facades;

use WpPluginner\Illuminate\Notifications\ChannelManager;
use WpPluginner\Illuminate\Support\Testing\Fakes\NotificationFake;

/**
 * @see \WpPluginner\Illuminate\Notifications\ChannelManager
 */
class Notification extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new NotificationFake);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ChannelManager::class;
    }
}

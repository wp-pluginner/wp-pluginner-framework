<?php

namespace WpPluginner\Illuminate\Support\Facades;

use WpPluginner\Illuminate\Notifications\ChannelManager;
use WpPluginner\Illuminate\Notifications\AnonymousNotifiable;
use WpPluginner\Illuminate\Support\Testing\Fakes\NotificationFake;

/**
 * @see \WpPluginner\Illuminate\Notifications\ChannelManager
 */
class Notification extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return \WpPluginner\Illuminate\Support\Testing\Fakes\NotificationFake
     */
    public static function fake()
    {
        static::swap($fake = new NotificationFake);

        return $fake;
    }

    /**
     * Begin sending a notification to an anonymous notifiable.
     *
     * @param  string  $channel
     * @param  mixed  $route
     * @return \WpPluginner\Illuminate\Notifications\AnonymousNotifiable
     */
    public static function route($channel, $route)
    {
        return (new AnonymousNotifiable)->route($channel, $route);
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

<?php

namespace WpPluginner\Illuminate\Support\Facades;

use WpPluginner\Illuminate\Support\Testing\Fakes\MailFake;

/**
 * @see \WpPluginner\Illuminate\Mail\Mailer
 */
class Mail extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new MailFake);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mailer';
    }
}

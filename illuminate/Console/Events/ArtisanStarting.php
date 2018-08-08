<?php

namespace WpPluginner\Illuminate\Console\Events;

class ArtisanStarting
{
    /**
     * The Artisan application instance.
     *
     * @var \WpPluginner\Illuminate\Console\Application
     */
    public $artisan;

    /**
     * Create a new event instance.
     *
     * @param  \WpPluginner\Illuminate\Console\Application  $artisan
     * @return void
     */
    public function __construct($artisan)
    {
        $this->artisan = $artisan;
    }
}

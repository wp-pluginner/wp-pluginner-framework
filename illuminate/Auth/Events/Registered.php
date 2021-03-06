<?php

namespace WpPluginner\Illuminate\Auth\Events;

use WpPluginner\Illuminate\Queue\SerializesModels;

class Registered
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \WpPluginner\Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \WpPluginner\Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}

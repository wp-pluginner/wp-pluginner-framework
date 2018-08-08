<?php

namespace WpPluginner\Illuminate\Auth\Events;

use WpPluginner\Illuminate\Http\Request;

class Lockout
{
    /**
     * The throttled request.
     *
     * @var \WpPluginner\Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}

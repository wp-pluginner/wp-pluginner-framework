<?php

namespace WpPluginner\Illuminate\Routing\Events;

class RouteMatched
{
    /**
     * The route instance.
     *
     * @var \WpPluginner\Illuminate\Routing\Route
     */
    public $route;

    /**
     * The request instance.
     *
     * @var \WpPluginner\Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \WpPluginner\Illuminate\Routing\Route  $route
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct($route, $request)
    {
        $this->route = $route;
        $this->request = $request;
    }
}

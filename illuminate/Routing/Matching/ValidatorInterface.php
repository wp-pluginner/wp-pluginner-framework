<?php

namespace WpPluginner\Illuminate\Routing\Matching;

use WpPluginner\Illuminate\Http\Request;
use WpPluginner\Illuminate\Routing\Route;

interface ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \WpPluginner\Illuminate\Routing\Route  $route
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request);
}

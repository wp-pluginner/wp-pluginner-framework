<?php

namespace WpPluginner\Illuminate\Routing\Matching;

use WpPluginner\Illuminate\Http\Request;
use WpPluginner\Illuminate\Routing\Route;

class HostValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \WpPluginner\Illuminate\Routing\Route  $route
     * @param  \WpPluginner\Illuminate\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        if (is_null($route->getCompiled()->getHostRegex())) {
            return true;
        }

        return preg_match($route->getCompiled()->getHostRegex(), $request->getHost());
    }
}

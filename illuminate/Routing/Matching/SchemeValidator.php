<?php

namespace WpPluginner\Illuminate\Routing\Matching;

use WpPluginner\Illuminate\Http\Request;
use WpPluginner\Illuminate\Routing\Route;

class SchemeValidator implements ValidatorInterface
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
        if ($route->httpOnly()) {
            return ! $request->secure();
        } elseif ($route->secure()) {
            return $request->secure();
        }

        return true;
    }
}

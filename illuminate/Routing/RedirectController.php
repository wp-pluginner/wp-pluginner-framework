<?php

namespace WpPluginner\Illuminate\Routing;

use WpPluginner\Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    /**
     * Invoke the controller method.
     *
     * @param  array  $args
     * @return \WpPluginner\Illuminate\Http\RedirectResponse
     */
    public function __invoke(...$args)
    {
        list($destination, $status) = array_slice($args, -2);

        return new RedirectResponse($destination, $status);
    }
}

<?php

namespace WpPluginner\Illuminate\Support\Facades;

/**
 * @method static \WpPluginner\Illuminate\Routing\Route get(string $uri, \Closure|array|string|null $action = null)
 * @method static \WpPluginner\Illuminate\Routing\Route post(string $uri, \Closure|array|string|null $action = null)
 * @method static \WpPluginner\Illuminate\Routing\Route put(string $uri, \Closure|array|string|null $action = null)
 * @method static \WpPluginner\Illuminate\Routing\Route delete(string $uri, \Closure|array|string|null $action = null)
 * @method static \WpPluginner\Illuminate\Routing\Route patch(string $uri, \Closure|array|string|null $action = null)
 * @method static \WpPluginner\Illuminate\Routing\Route options(string $uri, \Closure|array|string|null $action = null)
 * @method static \WpPluginner\Illuminate\Routing\Route any(string $uri, \Closure|array|string|null $action = null)
 * @method static \WpPluginner\Illuminate\Routing\Route match(array|string $methods, string $uri, \Closure|array|string|null $action = null)
 * @method static \WpPluginner\Illuminate\Routing\Route prefix(string  $prefix)
 * @method static void resource(string $name, string $controller, array $options = [])
 * @method static void apiResource(string $name, string $controller, array $options = [])
 * @method static void group(array $attributes, \Closure|string $callback)
 * @method static \WpPluginner\Illuminate\Routing\Route middleware(array|string|null $middleware)
 * @method static \WpPluginner\Illuminate\Routing\Route substituteBindings(\WpPluginner\Illuminate\Routing\Route $route)
 * @method static void substituteImplicitBindings(\WpPluginner\Illuminate\Routing\Route $route)
 *
 * @see \WpPluginner\Illuminate\Routing\Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}

<?php

namespace WpPluginner\Wordpress\StringBlade;

use Exception;
use Throwable;
use ArrayAccess;
use BadMethodCallException;
use WpPluginner\Illuminate\Support\Str;
use WpPluginner\Illuminate\Support\MessageBag;
use WpPluginner\Illuminate\Contracts\Support\Arrayable;
use WpPluginner\Illuminate\View\Engines\EngineInterface;
use WpPluginner\Illuminate\Contracts\Support\Renderable;
use WpPluginner\Illuminate\Contracts\Support\MessageProvider;
use WpPluginner\Illuminate\Contracts\View\View as ViewContract;
use WpPluginner\Illuminate\Contracts\View\Engine as Engine;

class View extends \WpPluginner\Illuminate\View\View
{

    /**
     * Create a new view instance.
     *
     * @param  \WpPluginner\Wordpress\StringBlade\Factory  $factory
     * @param  \WpPluginner\Illuminate\View\Engines\EngineInterface  $engine
     * @param  string  $view
     * @param  string  $path
     * @param  array   $data
     *
     */
    public function __construct(Factory $factory, Engine $engine, $view, $path, $data = [])
    {
        $this->view = $view;
        $this->path = $path;
        $this->engine = $engine;
        $this->factory = $factory;

        $this->data = $data instanceof Arrayable ? $data->toArray() : (array) $data;

    }

}

<?php

namespace WpPluginner\Illuminate\Routing;

use WpPluginner\Illuminate\Contracts\View\Factory as ViewFactory;

class ViewController extends Controller
{
    /**
     * The view factory implementation.
     *
     * @var \WpPluginner\Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Create a new controller instance.
     *
     * @param  \WpPluginner\Illuminate\Contracts\View\Factory  $view
     * @return void
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    /**
     * Invoke the controller method.
     *
     * @param  array  $args
     * @return \WpPluginner\Illuminate\Contracts\View\View
     */
    public function __invoke(...$args)
    {
        list($view, $data) = array_slice($args, -2);

        return $this->view->make($view, $data);
    }
}

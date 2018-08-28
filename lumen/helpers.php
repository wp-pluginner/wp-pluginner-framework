<?php

use WpPluginner\Illuminate\Support\Str;
use WpPluginner\Illuminate\Container\Container;
use WpPluginner\Illuminate\Contracts\Bus\Dispatcher;

if (! function_exists('wp_pluginner_abort')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param  int     $code
     * @param  string  $message
     * @param  array   $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function wp_pluginner_abort($code, $message = '', array $headers = [])
    {
        return wp_pluginner()->abort($code, $message, $headers);
    }
}

if (! function_exists('wp_pluginner')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $make
     * @return mixed|\WpPluginner\Lumen\Application
     */
    function wp_pluginner($make = null)
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($make);
    }
}

if (! function_exists('wp_pluginner_filename')) {
    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path
     * @return string
     */
    function wp_pluginner_filename()
    {
        return wp_pluginner()->filename;
    }
}

if (! function_exists('wp_pluginner_base_url')) {
    /**
     * Get the url to the base of the install.
     *
     * @param  string  $path
     * @return string
     */
    function wp_pluginner_base_url($path = '')
    {
        return wp_pluginner()->baseUrl($path);
    }
}

if (! function_exists('wp_pluginner_base_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path
     * @return string
     */
    function wp_pluginner_base_path($path = '')
    {
        return wp_pluginner()->basePath($path);
    }
}

if (! function_exists('wp_pluginner_decrypt')) {
    /**
     * Decrypt the given value.
     *
     * @param  string  $value
     * @return string
     */
    function wp_pluginner_decrypt($value)
    {
        return wp_pluginner('encrypter')->decrypt($value);
    }
}

if (! function_exists('wp_pluginner_dispatch')) {
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param  mixed  $job
     * @return mixed
     */
    function wp_pluginner_dispatch($job)
    {
        return wp_pluginner(Dispatcher::class)->dispatch($job);
    }
}

if (! function_exists('wp_pluginner_dispatch_now')) {
    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @param  mixed  $job
     * @param  mixed  $handler
     * @return mixed
     */
    function wp_pluginner_dispatch_now($job, $handler = null)
    {
        return wp_pluginner(Dispatcher::class)->dispatchNow($job, $handler);
    }
}

if (! function_exists('wp_pluginner_config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function wp_pluginner_config($key = null, $default = null)
    {
        if (is_null($key)) {
            return wp_pluginner('config');
        }

        if (is_array($key)) {
            return wp_pluginner('config')->set($key);
        }

        return wp_pluginner('config')->get($key, $default);
    }
}

if (! function_exists('wp_pluginner_config_path')) {
    /**
     * Get the path to the database directory of the install.
     *
     * @param  string  $path
     * @return string
     */
    function wp_pluginner_config_path($path = '')
    {
        return wp_pluginner()->configPath($path);
    }
}

if (! function_exists('wp_pluginner_database_path')) {
    /**
     * Get the path to the database directory of the install.
     *
     * @param  string  $path
     * @return string
     */
    function wp_pluginner_database_path($path = '')
    {
        return wp_pluginner()->databasePath($path);
    }
}

if (! function_exists('wp_pluginner_encrypt')) {
    /**
     * Encrypt the given value.
     *
     * @param  string  $value
     * @return string
     */
    function wp_pluginner_encrypt($value)
    {
        return wp_pluginner('encrypter')->encrypt($value);
    }
}

if (! function_exists('wp_pluginner_env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function wp_pluginner_env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return wp_pluginner_value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        if (Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (! function_exists('wp_pluginner_event')) {
    /**
     * Fire an event and call the listeners.
     *
     * @param  object|string  $event
     * @param  mixed   $payload
     * @param  bool    $halt
     * @return array|null
     */
    function wp_pluginner_event($event, $payload = [], $halt = false)
    {
        return wp_pluginner('events')->fire($event, $payload, $halt);
    }
}

if (! function_exists('wp_pluginner_factory')) {
    /**
     * Create a model factory builder for a given class, name, and amount.
     *
     * @param  dynamic  class|class,name|class,amount|class,name,amount
     * @return \WpPluginner\Illuminate\Database\Eloquent\FactoryBuilder
     */
    function wp_pluginner_factory()
    {
        wp_pluginner('db');

        $factory = wp_pluginner('WpPluginner\Illuminate\Database\Eloquent\Factory');

        $arguments = func_get_args();

        if (isset($arguments[1]) && is_string($arguments[1])) {
            return $factory->of($arguments[0], $arguments[1])->times(isset($arguments[2]) ? $arguments[2] : null);
        } elseif (isset($arguments[1])) {
            return $factory->of($arguments[0])->times($arguments[1]);
        } else {
            return $factory->of($arguments[0]);
        }
    }
}

if (! function_exists('wp_pluginner_info')) {
    /**
     * Write some information to the log.
     *
     * @param  string  $message
     * @param  array   $context
     * @return void
     */
    function wp_pluginner_info($message, $context = [])
    {
        return wp_pluginner('Psr\Log\LoggerInterface')->info($message, $context);
    }
}

if (! function_exists('wp_pluginner_redirect')) {
    /**
     * Get an instance of the redirector.
     *
     * @param  string|null  $to
     * @param  int     $status
     * @param  array   $headers
     * @param  bool    $secure
     * @return \WpPluginner\Lumen\Http\Redirector|\WpPluginner\Illuminate\Http\RedirectResponse
     */
    function wp_pluginner_redirect($to = null, $status = 302, $headers = [], $secure = null)
    {
        $redirector = new WpPluginner\Lumen\Http\Redirector(wp_pluginner());

        if (is_null($to)) {
            return $redirector;
        }

        return $redirector->to($to, $status, $headers, $secure);
    }
}

if (! function_exists('wp_pluginner_resource_path')) {
    /**
     * Get the path to the resources folder.
     *
     * @param  string  $path
     * @return string
     */
    function wp_pluginner_resource_path($path = '')
    {
        return wp_pluginner()->resourcePath($path);
    }
}

if (! function_exists('wp_pluginner_response')) {
    /**
     * Return a new response from the application.
     *
     * @param  string  $content
     * @param  int     $status
     * @param  array   $headers
     * @return \WpPluginner\Illuminate\Http\Response|\WpPluginner\Lumen\Http\ResponseFactory
     */
    function wp_pluginner_response($content = '', $status = 200, array $headers = [])
    {
        $factory = new WpPluginner\Lumen\Http\ResponseFactory;

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($content, $status, $headers);
    }
}

if (! function_exists('wp_pluginner_route')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $secure
     * @return string
     */
    function wp_pluginner_route($name, $parameters = [], $secure = null)
    {
        return wp_pluginner('url')->route($name, $parameters, $secure);
    }
}

if (! function_exists('wp_pluginner_storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param  string  $path
     * @return string
     */
    function wp_pluginner_storage_path($path = '')
    {
        return wp_pluginner()->storagePath($path);
    }
}

if (! function_exists('wp_pluginner_trans')) {
    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $replace
     * @param  string  $locale
     * @return \WpPluginner\Illuminate\Contracts\Translation\Translator|string
     */
    function wp_pluginner_trans($id = null, $replace = [], $locale = null)
    {
        if (is_null($id)) {
            return wp_pluginner('translator');
        }

        return wp_pluginner('translator')->trans($id, $replace, $locale);
    }
}

if (! function_exists('wp_pluginner_trans_choice')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string  $id
     * @param  int|array|\Countable  $number
     * @param  array   $replace
     * @param  string  $locale
     * @return string
     */
    function wp_pluginner_trans_choice($id, $number, array $replace = [], $locale = null)
    {
        return wp_pluginner('translator')->transChoice($id, $number, $replace, $locale);
    }
}

if (! function_exists('wp_pluginner_url')) {
    /**
     * Generate a url for the application.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @param  bool    $secure
     * @return string
     */
    function wp_pluginner_url($path = null, $parameters = [], $secure = null)
    {
        return wp_pluginner('url')->to($path, $parameters, $secure);
    }
}

if (! function_exists('wp_pluginner_view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return \WpPluginner\Illuminate\View\View
     */
    function wp_pluginner_view($view = null, $data = [], $mergeData = [])
    {
        $factory = wp_pluginner('view');

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }
}

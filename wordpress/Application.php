<?php

namespace WpPluginner\Wordpress;

use WpPluginner\Lumen\Application as LumenContainer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use WpPluginner\Illuminate\Support\ServiceProvider;
use WpPluginner\Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use WpPluginner\Illuminate\Config\Repository as ConfigRepository;
use WpPluginner\Illuminate\Http\Request as IlluminateRequest;

class Application extends LumenContainer
{
    /**
     * The filename of the application installation.
     *
     * @var string
     */
    public $filename;

    /**
     * The base url of the application installation.
     *
     * @var string
     */
    protected $baseUrl;

    protected $booted = false;
    protected $serviceProviders = [];

    /**
     * Create a new Lumen application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($filename = null)
    {
        if (! empty(wp_pluginner_env('APP_TIMEZONE'))) {
            date_default_timezone_set(wp_pluginner_env('APP_TIMEZONE', 'UTC'));
        }
        $this->filename = $filename;
        $this->basePath = untrailingslashit(plugin_dir_path($filename));
        $this->baseUrl = untrailingslashit(plugin_dir_url($filename));
        $this->bootstrapContainer();
        $this->registerErrorHandling();
        if (!$this->runningInConsole()) {
            if($this['config']->get('session.enabled')){
        		$this->bind(\WpPluginner\Illuminate\Session\SessionManager::class, function ($app) {
        			return new \WpPluginner\Illuminate\Session\SessionManager($app);
        		});
        		$this->register(\WpPluginner\Illuminate\Session\SessionServiceProvider::class);
        		$this->middleware([\WpPluginner\Illuminate\Session\Middleware\StartSession::class]);
        	}
            $this->instance('request', IlluminateRequest::capture());
        }
    }

    /**
     * Bootstrap the application container.
     *
     * @return void
     */
    protected function bootstrapContainer()
    {
        static::setInstance($this);

        $this->instance('app', $this);

        $this->instance('filename', $this->filename);
        $this->instance('path', $this->path());


        $this->registerContainerAliases();
        $this->loadConfigurations();
        $this->make('db');
    }

    /**
     * Get the path to the database directory.
     *
     * @param  string  $path
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function environment()
    {
        $env = wp_pluginner_env('APP_ENV', wp_pluginner_config('app.env', 'production'));

        if (func_num_args() > 0) {
            $patterns = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

            foreach ($patterns as $pattern) {
                if (Str::is($pattern, $env)) {
                    return true;
                }
            }

            return false;
        }

        return $env;
    }

    /**
	 * Load Configurations.
	 * @return void
	 */
	public function loadConfigurations()
	{
        $items = [];
        $cached = $this->basePath('bootstrap/cache/config.php');
        if (wp_pluginner_env('APP_ENV') == 'production' && file_exists($cached)) {
            $items = require $cached;
            $loadedFromCache = true;
        }

        $this->instance('config', $config = new ConfigRepository($items));

        if (! isset($loadedFromCache)) {
            foreach ($this['files']->files($this->app->basePath('config')) as $configFile) {
    			$this->configure(basename($configFile, '.php'));
    		}
        }

	}

    /**
     * Register a service provider with the application.
     *
     * @param  \WpPluginner\Illuminate\Support\ServiceProvider|string  $provider
     * @return \WpPluginner\Illuminate\Support\ServiceProvider
     */
    public function register($provider)
    {
        if ($registered = $this->getProvider($provider)) {
            return $registered;
        }

        if (is_string($provider)) {
            $provider = new $provider($this);
        }

        if (method_exists($provider, 'register')) {
            $provider->register();
        }

        $this->markAsRegistered($provider);

        if ($this->booted) {
            return $this->bootProvider($provider);
        }
    }

    protected function getProvider($provider)
    {
        return array_values($this->getProviders($provider))[0] ?? null;
    }

    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call([$provider, 'boot']);
        }
    }

    protected function getProviders($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::where($this->serviceProviders, function($value) use ($name) {
            return $value instanceof $name;
        });
    }

    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[] = $provider;
        $this->loadedProviders[get_class($provider)] = true;
    }

    /**
     * {@inheritdoc}
     */
    public function bootPlugin()
    {
        $this->boot();
        /*
        if ($this->runningInConsole()) {
            return;
        }
        if (!is_admin() || !wp_doing_ajax()) {
            return;
        }
        $response = $this->dispatch($this['request']);

        return $response;
        */
    }

    /**
     * Get the Monolog handler for the application.
     *
     * @return \Monolog\Handler\AbstractHandler
     */
    protected function getMonologHandler()
    {
        return (new StreamHandler(wp_pluginner_storage_path('logs/wp_pluginner.log'), Logger::DEBUG))
                            ->setFormatter(new LineFormatter(null, null, true, true));
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return 'WpPluginner (5.4.7) (Lumen Components 5.4.*)';
    }

    /**
     * Get the base path for the application.
     *
     * @param  string|null  $path
     * @return string
     */
    public function baseUrl($path = null)
    {
        if (isset($this->baseUrl)) {
            return $this->baseUrl.($path ? '/'.$path : $path);
        }

        if ($this->runningInConsole()) {
            $this->baseUrl = getcwd();
        } else {
            $this->baseUrl = realpath(getcwd().'/../');
        }

        return $this->baseUrl($path);
    }

    public function prepareForConsoleCommand($aliases = true)
    {
        $this->withFacades($aliases);

        $this->make('cache');
        $this->make('queue');

        $this->configure('database');

        $this->register('WpPluginner\Illuminate\Database\MigrationServiceProvider');
        $this->register('WpPluginner\Wordpress\Console\ConsoleServiceProvider');
    }

    protected function registerContainerAliases()
    {
        $this->aliases = [
            'WpPluginner\Illuminate\Contracts\Foundation\Application' => 'app',
            'WpPluginner\Lumen\Application' => 'app',
            'WpPluginner\Wordpress\Application' => 'app',
            'WpPluginner\Illuminate\Contracts\Cache\Factory' => 'cache',
            'WpPluginner\Illuminate\Contracts\Cache\Repository' => 'cache.store',
            'WpPluginner\Illuminate\Contracts\Config\Repository' => 'config',
            'WpPluginner\Illuminate\Container\Container' => 'app',
            'WpPluginner\Illuminate\Contracts\Container\Container' => 'app',
            'WpPluginner\Illuminate\Database\ConnectionResolverInterface' => 'db',
            'WpPluginner\Illuminate\Database\DatabaseManager' => 'db',
            'WpPluginner\Illuminate\Contracts\Encryption\Encrypter' => 'encrypter',
            'WpPluginner\Illuminate\Contracts\Events\Dispatcher' => 'events',
            'WpPluginner\Illuminate\Contracts\Hashing\Hasher' => 'hash',
            'log' => 'Psr\Log\LoggerInterface',
            'WpPluginner\Illuminate\Contracts\Queue\Factory' => 'queue',
            'WpPluginner\Illuminate\Contracts\Queue\Queue' => 'queue.connection',
            'request' => 'WpPluginner\Illuminate\Http\Request',
            'WpPluginner\Lumen\Routing\UrlGenerator' => 'url',
            'WpPluginner\Illuminate\Contracts\Validation\Factory' => 'validator',
            'WpPluginner\Illuminate\Contracts\View\Factory' => 'view',
        ];
    }

    public function boot()
    {
        if ($this->booted) {
            return;
        }

        array_walk($this->serviceProviders, function($p) {
            $this->bootProvider($p);
        });

        $this->booted = true;
    }

    protected function registerViewBindings()
    {
        $this->singleton('view', function () {
            return $this->loadComponent('view', 'WpPluginner\Wordpress\StringBlade\ViewServiceProvider');
        });
    }

}

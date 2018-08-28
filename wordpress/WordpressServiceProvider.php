<?php

namespace WpPluginner\Wordpress;

use WpPluginner\Wordpress\Hook\Action;
use WpPluginner\Wordpress\Hook\Filter;
use WpPluginner\Wordpress\Hook\AdminMenu;
use WpPluginner\Illuminate\Support\ServiceProvider;

class WordpressServiceProvider extends ServiceProvider
{

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([Console\DeployerCommand::class]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        /** Register Wordpress Helper **/
        $this->app->singleton('wp.action', Action::class);
        $this->app->singleton('wp.filter', Filter::class);
        $this->app->singleton('wp.admin.menu', AdminMenu::class);

        $this->loadPluginOptions();
        $this->loadPluginMetaData();
        $this->setDatabaseConfiguration();
    }

    protected function loadPluginOptions(){
        $plugin_options = get_option(
            wp_pluginner_snake_case($this->app['config']->get('app.name', 'Wp Pluginner')) . '_options'
        );
        if (is_array($plugin_options)) {
            $default_options = $this->app['config']->get('options', []);
            if (is_array($default_options)) $plugin_options = array_merge($default_options, $plugin_options);
            $this->app['config']->set(['options' => $plugin_options]);
        }
    }

    protected function loadPluginMetaData(){
        if (!function_exists('get_plugin_data')) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        $this->app['config']->set(['meta' => get_plugin_data( $this->app->filename )]);
    }

    /**
	 * Set Database mysql connection with WP Database
	 * @return array
	 */
	public function setDatabaseConfiguration()
	{
		global $wpdb;
        $this->app['config']->set([
            'database.connections.mysql' => [
    			'driver'    => 'mysql',
    			'host'      => DB_HOST,
    			'database'  => DB_NAME,
    			'username'  => DB_USER,
    			'password'  => DB_PASSWORD,
    			'charset'   => $wpdb->charset,
    			'collation' => $wpdb->collate,
    			'prefix'    => $wpdb->prefix,
    			'timezone'  => '+00:00',
    			'strict'    => false,
    		]
        ]);
	}
}

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => wp_pluginner_env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'testing' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ],

        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => wp_pluginner_env('DB_DATABASE', wp_pluginner_base_path('database/database.sqlite')),
            'prefix'   => wp_pluginner_env('DB_PREFIX', ''),
        ],

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => wp_pluginner_env('DB_HOST', 'localhost'),
            'port'      => wp_pluginner_env('DB_PORT', 3306),
            'database'  => wp_pluginner_env('DB_DATABASE', 'forge'),
            'username'  => wp_pluginner_env('DB_USERNAME', 'forge'),
            'password'  => wp_pluginner_env('DB_PASSWORD', ''),
            'charset'   => wp_pluginner_env('DB_CHARSET', 'utf8'),
            'collation' => wp_pluginner_env('DB_COLLATION', 'utf8_unicode_ci'),
            'prefix'    => wp_pluginner_env('DB_PREFIX', ''),
            'timezone'  => wp_pluginner_env('DB_TIMEZONE', '+00:00'),
            'strict'    => wp_pluginner_env('DB_STRICT_MODE', false),
        ],

        'pgsql' => [
            'driver'   => 'pgsql',
            'host'     => wp_pluginner_env('DB_HOST', 'localhost'),
            'port'     => wp_pluginner_env('DB_PORT', 5432),
            'database' => wp_pluginner_env('DB_DATABASE', 'forge'),
            'username' => wp_pluginner_env('DB_USERNAME', 'forge'),
            'password' => wp_pluginner_env('DB_PASSWORD', ''),
            'charset'  => wp_pluginner_env('DB_CHARSET', 'utf8'),
            'prefix'   => wp_pluginner_env('DB_PREFIX', ''),
            'schema'   => wp_pluginner_env('DB_SCHEMA', 'public'),
        ],

        'sqlsrv' => [
            'driver'   => 'sqlsrv',
            'host'     => wp_pluginner_env('DB_HOST', 'localhost'),
            'database' => wp_pluginner_env('DB_DATABASE', 'forge'),
            'username' => wp_pluginner_env('DB_USERNAME', 'forge'),
            'password' => wp_pluginner_env('DB_PASSWORD', ''),
            'charset'  => wp_pluginner_env('DB_CHARSET', 'utf8'),
            'prefix'   => wp_pluginner_env('DB_PREFIX', ''),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => wp_pluginner_env('REDIS_CLUSTER', false),

        'default' => [
            'host'     => wp_pluginner_env('REDIS_HOST', '127.0.0.1'),
            'port'     => wp_pluginner_env('REDIS_PORT', 6379),
            'database' => wp_pluginner_env('REDIS_DATABASE', 0),
            'password' => wp_pluginner_env('REDIS_PASSWORD', null),
        ],

    ],

];

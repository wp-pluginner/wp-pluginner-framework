<?php

namespace WpPluginner\Illuminate\Contracts\Redis;

interface Factory
{
    /**
     * Get a Redis connection by name.
     *
     * @param  string  $name
     * @return \WpPluginner\Illuminate\Redis\Connections\Connection
     */
    public function connection($name = null);
}

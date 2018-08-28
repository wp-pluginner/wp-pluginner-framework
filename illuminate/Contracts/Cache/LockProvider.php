<?php

namespace WpPluginner\Illuminate\Contracts\Cache;

interface LockProvider
{
    /**
     * Get a lock instance.
     *
     * @param  string  $name
     * @param  int  $seconds
     * @return \WpPluginner\Illuminate\Contracts\Cache\Lock
     */
    public function lock($name, $seconds = 0);
}

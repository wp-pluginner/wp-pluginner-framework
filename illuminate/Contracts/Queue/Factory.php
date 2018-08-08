<?php

namespace WpPluginner\Illuminate\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param  string  $name
     * @return \WpPluginner\Illuminate\Contracts\Queue\Queue
     */
    public function connection($name = null);
}

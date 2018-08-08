<?php

namespace WpPluginner\Illuminate\Queue\Connectors;

interface ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \WpPluginner\Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config);
}

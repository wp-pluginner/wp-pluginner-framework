<?php

namespace WpPluginner\Illuminate\Contracts\Filesystem;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string  $name
     * @return \WpPluginner\Illuminate\Contracts\Filesystem\Filesystem
     */
    public function disk($name = null);
}

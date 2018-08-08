<?php

namespace WpPluginner\Illuminate\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \WpPluginner\Illuminate\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}

<?php

namespace WpPluginner\Illuminate\Contracts\Broadcasting;

use WpPluginner\Illuminate\Broadcasting\Channel;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|Channel[]
     */
    public function broadcastOn();
}

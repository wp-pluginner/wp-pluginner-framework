<?php

namespace WpPluginner\Illuminate\Broadcasting;

use ReflectionClass;
use ReflectionProperty;
use WpPluginner\Illuminate\Bus\Queueable;
use WpPluginner\Illuminate\Contracts\Queue\Job;
use WpPluginner\Illuminate\Contracts\Queue\ShouldQueue;
use WpPluginner\Illuminate\Contracts\Support\Arrayable;
use WpPluginner\Illuminate\Contracts\Broadcasting\Broadcaster;

class BroadcastEvent implements ShouldQueue
{
    use Queueable;

    /**
     * The event instance.
     *
     * @var mixed
     */
    public $event;

    /**
     * Create a new job handler instance.
     *
     * @param  mixed  $event
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Handle the queued job.
     *
     * @param  \WpPluginner\Illuminate\Contracts\Broadcasting\Broadcaster  $broadcaster
     * @return void
     */
    public function handle(Broadcaster $broadcaster)
    {
        $name = method_exists($this->event, 'broadcastAs')
                ? $this->event->broadcastAs() : get_class($this->event);

        $broadcaster->broadcast(
            wp_pluginner_array_wrap($this->event->broadcastOn()), $name,
            $this->getPayloadFromEvent($this->event)
        );
    }

    /**
     * Get the payload for the given event.
     *
     * @param  mixed  $event
     * @return array
     */
    protected function getPayloadFromEvent($event)
    {
        if (method_exists($event, 'broadcastWith')) {
            return array_merge(
                $event->broadcastWith(), ['socket' => wp_pluginner_data_get($event, 'socket')]
            );
        }

        $payload = [];

        foreach ((new ReflectionClass($event))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $payload[$property->getName()] = $this->formatProperty($property->getValue($event));
        }

        unset($payload['broadcastQueue']);

        return $payload;
    }

    /**
     * Format the given value for a property.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function formatProperty($value)
    {
        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        return $value;
    }

    /**
     * Get the display name for the queued job.
     *
     * @return string
     */
    public function displayName()
    {
        return get_class($this->event);
    }
}

<?php


namespace Oxygen\Exceptions\Event;


use Exception;
use Oxygen\Contracts\Events\EventListenerContract;

class ListenerAlreadyAttachedToEvent  extends Exception
{
    public function __construct(string $event, EventListenerContract $listener)
    {
        $listenerClass = get_class($listener);
        parent::__construct("Listener [$listenerClass] has already been bound to the event [$event]");
    }
}

<?php


namespace Oxygen\Event;


use Oxygen\Contracts\Events\EventContract;

abstract class AbstractEvent implements EventContract
{
    protected $propagationStopped = false;

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    public function stopPropagation()
    {
        return $this->propagationStopped = true;
    }
}
<?php


namespace Oxygen\Contracts\Events;


use Psr\EventDispatcher\StoppableEventInterface;

interface EventContract extends StoppableEventInterface
{
    public function stopPropagation();

}
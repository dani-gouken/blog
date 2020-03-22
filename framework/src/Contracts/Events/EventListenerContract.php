<?php


namespace Oxygen\Contracts\Events;


interface EventListenerContract
{
    public function handle(EventContract $event):void;
    public function canBeCalled():bool;
    public function getPriority();

}
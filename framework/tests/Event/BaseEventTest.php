<?php

namespace Oxygen\Test\Event;
use Oxygen\Contracts\Events\EventContract;
use Oxygen\Contracts\Events\EventListenerContract;
use Oxygen\Test\BasicTest;
use PHPUnit\Framework\MockObject\MockObject;

class BaseEventTest extends BasicTest
{
    protected function getClassName($className) {
        $path = explode('\\', $className);
        return array_pop($path);
    }
    /**
     * @return EventListenerContract | MockObject
     */
    protected function buildListener(){
        $listener = $this->getMockBuilder(EventListenerContract::class)
            ->setMockClassName($this->getClassName(EventListenerContract::class)."_".rand())->getMock();
        return $listener;
    }

    /**
     * @return EventContract | MockObject
     */
    protected function buildEvent(){
        $event = $this->getMockBuilder(EventContract::class)
            ->setMockClassName($this->getClassName(EventContract::class)."_".rand())->getMock();
        return $event;
    }

}
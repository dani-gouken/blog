<?php


namespace Infrastructure\DebugBar\Listeners;


use Infrastructure\DebugBar\Collectors\MiddlewareCollector;
use Oxygen\Contracts\Events\EventContract;
use Oxygen\Event\AbstractEventListener;
use Oxygen\Event\ApplicationEvents\MiddlewareLoaded;

class MiddlewareLoadedListener extends AbstractEventListener
{
    /**
     * @var MiddlewareCollector
     */
    private $collector;

    public function __construct(MiddlewareCollector $collector)
    {
        $this->collector = $collector;
    }

    public function on(EventContract $event): void
    {
        /**
         * @var $event MiddlewareLoaded
         */
        $this->collector->addMiddleware($event->getRelatedMiddleware());
    }
}
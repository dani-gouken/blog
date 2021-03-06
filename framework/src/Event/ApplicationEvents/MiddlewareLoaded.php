<?php


namespace Oxygen\Event\ApplicationEvents;


use Oxygen\Event\AbstractEvent;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareLoaded extends AbstractEvent
{
    /**
     * @var MiddlewareInterface
     */
    private $middleware;

    public function __construct(MiddlewareInterface $middleware)
    {
        $this->middleware = $middleware;
    }

    public function getRelatedMiddleware(){
        return $this->middleware;
    }

}
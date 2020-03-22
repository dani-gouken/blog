<?php


namespace Infrastructure\DebugBar;


use DebugBar\Bridge\DoctrineCollector;
use DebugBar\StandardDebugBar;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManager;
use Infrastructure\DebugBar\Collectors\MiddlewareCollector;
use Infrastructure\DebugBar\Collectors\RouteCollector;
use Infrastructure\DebugBar\Listeners\MiddlewareLoadedListener;
use Oxygen\Contracts\AppContract;
use Oxygen\Event\ApplicationEvents\MiddlewareLoaded;

class OxygenDebugBar extends StandardDebugBar
{
    /**
     * OxygenDebugBar constructor.
     * @param AppContract $app
     * @throws \DebugBar\DebugBarException
     */
    public function __construct(AppContract $app)
    {
        parent::__construct();
        /**
         * @var $em EntityManager
         */
        $em = $app->getContainer()->get(EntityManager::class);
        $debugStack = new DebugStack();
        $em->getConnection()->getConfiguration()->setSQLLogger($debugStack);
        $this->addCollector(new DoctrineCollector($debugStack));
        $middlewareCollector = new MiddlewareCollector();
        $this->addCollector($middlewareCollector);
        $app->getEventDispatcher()->addEventListener(MiddlewareLoaded::class,new MiddlewareLoadedListener($middlewareCollector));
    }

}
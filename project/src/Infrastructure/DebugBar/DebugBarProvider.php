<?php


namespace Infrastructure\DebugBar;



use Infrastructure\DebugBar\Collectors\MiddlewareCollector;
use Infrastructure\DebugBar\Listeners\MiddlewareLoadedListener;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Event\ApplicationEvents\MiddlewareLoaded;


class DebugBarProvider implements ServiceProviderContract
{

    /**
     * @param AppContract $app
     * @throws \Oxygen\Exceptions\RequestHandlerException
     */
    public function register(AppContract $app)
    {
        $debugBar = $app->getContainer()->get(OxygenDebugBar::class);
        $app->getContainer()->set(OxygenDebugBar::class, $debugBar);
        $app->pipe(DebugBarAssetMiddleware::class);
        $app->pipe(DebugBarMiddleware::class);
    }
}
<?php


namespace Oxygen\Providers\Routing;

use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Routing\RouterContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Providers\Configurator\Configurator;
use Psr\Container\NotFoundExceptionInterface;

class RoutingProvider implements ServiceProviderContract
{
    /**
     * @param AppContract $app
     */
    public function register(AppContract $app)
    {
        try{
            $config = $app->get(Configurator::class);
            $host = $config->get("app.host",null);
        }catch (NotFoundExceptionInterface $e){
            $host = null;
        }
        $router = new Router($host);
        $app->getContainer()->set(RouterContract::class,$router);
        $app->getContainer()->set(Router::class,$router);
    }
}
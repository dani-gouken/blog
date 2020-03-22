<?php


namespace Oxygen\Providers\Routing;

use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Routing\RouterContract;
use Oxygen\Contracts\ServiceProviderContract;

class RoutingProvider implements ServiceProviderContract
{
    /**
     * @var string
     */
    private $host;

    public function __construct(string $host = null)
    {
        $this->host = $host;
    }

    /**
     * @param AppContract $app
     */
    public function register(AppContract $app)
    {
        $router = new Router($this->host);
        $app->getContainer()->set(RouterContract::class,$router);
        $app->getContainer()->set(Router::class,$router);
    }
}
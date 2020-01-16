<?php
namespace Oxygen\Contracts\Providers\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface RouteGroupContract extends AbstractRouteContract
{
    public function add(RouteContract $route):?RouteGroupContract;

    /**
     * @return RouteContract[]
     */
    public function getRoutes():array;
}

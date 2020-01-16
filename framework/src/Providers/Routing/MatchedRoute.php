<?php
namespace Oxygen\Providers\Routing;

use Oxygen\Contracts\Providers\Routing\RouteContract;

class MatchedRoute
{
    public $route;
    public $arguments = [];

    public function __construct(RouteContract $route, array $arguments)
    {
        $this->route = $route;
        $this->arguments = $arguments;
    }
}

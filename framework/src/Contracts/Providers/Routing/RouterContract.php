<?php
namespace Oxygen\Contracts\Providers\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface RouterContract
{
    public function dispatch(ServerRequestInterface $request);
    public function add(AbstractRouteContract $route):self;
    public function generateUrl(String $routeName, Array $args = []):?String;
}

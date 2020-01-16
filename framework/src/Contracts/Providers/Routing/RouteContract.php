<?php

    namespace Oxygen\Contracts\Providers\Routing;

    use Psr\Http\Message\ServerRequestInterface;

interface RouteContract extends AbstractRouteContract
{

    public function getMethods():array;
    public function setMethods(Array $methods):AbstractRouteContract;
    public function setRouteGroup(RouteGroupContract $routeGroup):AbstractRouteContract;

    public function setName(String $name):AbstractRouteContract;
    public function getName():String;

    public function getRouteGroup():?RouteGroupContract;
}

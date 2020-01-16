<?php

    namespace Oxygen\Contracts\Providers\Routing;

    use Psr\Http\Message\ServerRequestInterface;

interface AbstractRouteContract
{
    public function getPattern():String;
    public function setPattern(String $methods):self;

    public function setMiddleware($middleware):self;
    public function getMiddleware();
}

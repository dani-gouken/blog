<?php

namespace Oxygen\Providers\Routing\Middlewares;

use Oxygen\Providers\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteHandlerMiddleware implements MiddlewareInterface
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $matchedRoute = $this->router->getMatchedRoute($request);
        $route = $matchedRoute->route;
        $routeGroup = $route->getRouteGroup();
        if ($routeGroup && $routeGroup->getMiddleware()) {
            $handler->pipeReplacement($routeGroup->getMiddleware());
        }
        $handler->pipeReplacement($route->getMiddleware());
        return $handler->handle($request);
    }
}

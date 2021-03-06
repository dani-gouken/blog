<?php

namespace Oxygen\Providers\Routing\Middlewares;

use Oxygen\Providers\Routing\Exceptions\MethodNotAllowedException;
use Oxygen\Providers\Routing\Exceptions\RouteNotFoundException;
use Oxygen\Providers\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteDispatcherMiddleware implements MiddlewareInterface
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
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $matchedRoute = $this->router->dispatch($request);
        $request = $request->withAttribute($this->router::MATCHED_ROUTE_ATTRIBUTE_KEY, $matchedRoute);
        return $handler->handle($request);
    }
}

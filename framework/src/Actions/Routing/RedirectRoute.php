<?php


namespace Oxygen\Actions\Routing;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RedirectRoute implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $route;
    /**
     * @var array
     */
    private $data;
    /**
     * @var int
     */
    private $status;
    /**
     * @var array
     */
    private $headers;

    public function __construct(string $route,$data = [],int $status = 302,array $headers = [])
    {
        $this->route = $route;
        $this->data = $data;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
       return redirectRoute($this->route,$this->data,$this->status,$this->headers);
    }
}
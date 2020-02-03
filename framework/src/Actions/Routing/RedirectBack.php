<?php


namespace Oxygen\Actions\Routing;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RedirectBack implements MiddlewareInterface
{
    /**
     * @var int
     */
    private $status;
    /**
     * @var array
     */
    private $headers;

    public function __construct(int $status = 302, $headers = [])
    {
        $this->status = $status;
        $this->headers = $headers;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return redirectBack($request,$this->status,$this->headers);
    }
}
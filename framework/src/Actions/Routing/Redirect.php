<?php


namespace Oxygen\Actions\Routing;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Redirect implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var int
     */
    private $status;
    /**
     * @var array
     */
    private $headers;

    public function __construct(string $url,int $status=302,array $headers =[])
    {
        $this->url = $url;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
       return redirect($this->url,$this->status,$this->headers);
    }
}
<?php

namespace Oxygen\AbstractTypes;
use Fig\Http\Message\RequestMethodInterface;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;

abstract class AbstractWebController
{
    private $controllerMethods = [
        RequestMethodInterface::METHOD_HEAD,
        RequestMethodInterface::METHOD_GET,
        RequestMethodInterface::METHOD_POST,
        RequestMethodInterface::METHOD_PUT,
        RequestMethodInterface::METHOD_PATCH,
        RequestMethodInterface::METHOD_DELETE,
        RequestMethodInterface::METHOD_PURGE,
        RequestMethodInterface::METHOD_OPTIONS,
        RequestMethodInterface::METHOD_TRACE,
        RequestMethodInterface::METHOD_CONNECT,
    ];
    /**
     * @var RendererContract
     */
    protected $renderer;

    public function __construct(RendererContract $renderer)
    {
        $this->renderer = $renderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->controllerMethods as $methods) {
            if ($request->getMethod() == $methods){
                return $this->{"do".ucfirst(strtolower($methods))}($request,$handler);
            }
        }
        return new EmptyResponse();
    }

    protected function render(string $view){
        return new HtmlResponse($this->renderer->render($view));
    }
}
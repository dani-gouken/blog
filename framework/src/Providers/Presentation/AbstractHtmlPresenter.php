<?php


namespace Oxygen\Providers\Presentation;

use Oxygen\Contracts\Providers\Templating\RendererContract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

abstract class AbstractHtmlPresenter implements MiddlewareInterface
{
    /**
     * @var RendererContract
     */
    protected $statusCode;
    protected $headers;
    protected $template;
    protected $data = [];
    public function __construct(
        string $template,
        array $data = [],
        int $statusCode = 200,
        array $headers = []
    )
    {
        $this->template = $template;
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    protected function getData():array{
        return method_exists($this,"data") ? $this->data() : $this->data;
    }

    public function render(RequestHandlerInterface $handler):string{
        /**
         * @var $renderer RendererContract
         */
        $renderer = $handler->get(RendererContract::class);
        return $renderer->render($this->template,$this->getData());
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new HtmlResponse(
            $this->render($handler),
            $this->statusCode,
            $this->headers
        );
    }

}
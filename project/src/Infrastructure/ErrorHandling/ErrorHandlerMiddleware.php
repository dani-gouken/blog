<?php


namespace Infrastructure\ErrorHandling;


use Exception;
use Middlewares\Whoops;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Oxygen\Exceptions\Routing\RouteNotFoundException;
use Oxygen\Providers\Configurator\Configurator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    /**
     * @var RendererContract
     */
    private $renderer;
    /**
     * @var Configurator
     */
    private $config;

    public function __construct(RendererContract $renderer, Configurator $config)
    {
        $this->renderer = $renderer;
        $this->config = $config;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $environment = $this->config->get("app.environment", "development");
        if ($environment !== "development") {
            try {
                return $handler->handle($request);
            } catch (RouteNotFoundException $e) {
                return new HtmlResponse($this->renderer->render('errors/404'), 404);
            } catch (Exception $e) {
                return new HtmlResponse($this->renderer->render("errors/500"));
            }
        } else {
            $handler->pipe(Whoops::class);
            return $handler->handle($request);
        }

    }
}
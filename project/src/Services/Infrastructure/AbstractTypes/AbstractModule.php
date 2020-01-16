<?php

namespace App\Services\Infrastructure\AbstractTypes;
use Oxygen\Contracts\ContainerContract;
use Oxygen\Contracts\ModuleContract;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Oxygen\Providers\Configurator\Configurator;
use Oxygen\Providers\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractModule implements ModuleContract
{
    protected $router;
    protected $container;
    /**
     * @var Configurator
     */
    protected $config;
    /**
     * @var RendererContract
     */
    protected $renderer;

    public function __construct(
        Router $router,
        Configurator $config,
        RendererContract $renderer,
        ContainerContract $container
    )
    {
        $this->router = $router;
        $this->container = $container;
        $this->config = $config;
        $this->renderer = $renderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setUp($request,$handler);
        $this->addRoutes($this->router);
        return $handler->handle($request);
    }

    abstract protected function addRoutes(Router $router);
    abstract protected function setUp(ServerRequestInterface $request, RequestHandlerInterface $handler);

    public function getModuleName(){
        return property_exists($this,"MODULE_NAME") ? $this->MODULE_NAME :self::class;
    }

    public function getModuleDescription(){
        return property_exists($this,"MODULE_DESCRIPTION") ? $this->MODULE_DESCRIPTION :self::class;
    }
}
<?php


namespace Oxygen\Contracts;

use Oxygen\Exceptions\RequestHandlerException;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface AppContract extends RequestHandlerInterface
{
    /**
     * @param $middleware
     * @return $this
     * @throws RequestHandlerException
     */
    public function pipe($middleware): self;


    /**
     * @param $middleware
     * @return $this
     * @throws RequestHandlerException
     */
    public function pipeNext($middleware): self;

    /**
     * @param int $index
     * @param $middleware
     * @return $this
     * @throws RequestHandlerException
     */
    public function pipeAtPosition(int $index, $middleware): self;

    /**
     * @return array
     */
    public function getMiddlewares();

    /**
     * @return ContainerContract
     */
    public function getContainer():ContainerContract;

    /**
     * @param ServiceProviderContract $provider
     * @return AppContract
     */
    public function use(ServiceProviderContract $provider):self;

    /**
     * @param string|null $path
     * @return string
     */
    public function appPath(string $path = null):string;

    /**
     * @param MiddlewareInterface|string $middleware
     * @return AppContract
     */
    public function pipeReplacement($middleware):AppContract;

}
<?php


namespace Infrastructure\ErrorHandling;

use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Exceptions\RequestHandlerException;

class ErrorHandlerProvider implements ServiceProviderContract
{

    /**
     * @param AppContract $app
     * @throws RequestHandlerException
     */
    public function register(AppContract $app)
    {
        $app->pipe(ErrorHandlerMiddleware::class);
    }
}
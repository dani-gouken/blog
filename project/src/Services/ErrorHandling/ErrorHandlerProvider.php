<?php


namespace App\Services\ErrorHandling;


use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;

class ErrorHandlerProvider implements ServiceProviderContract
{

    public function register(AppContract $app)
    {
        $app->pipe(ErrorHandlerMiddleware::class);
    }
}
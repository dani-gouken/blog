<?php

namespace App;
use App\Modules\Admin\AdminModule;
use App\Modules\Front\FrontModule;
use Oxygen\Contracts\AppContract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Main implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /**
         * @var $handler AppContract
         */
        // [MODULES] 
		$handler->load(AdminModule::class);
		$handler->load(FrontModule::class);
        return $handler->handle($request);
    }
}
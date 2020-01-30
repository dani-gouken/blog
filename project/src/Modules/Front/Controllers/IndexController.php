<?php

namespace App\Modules\Front\Controllers;

use Oxygen\AbstractTypes\AbstractWebController;
use Oxygen\Providers\Presentation\HtmlPresenter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexController extends AbstractWebController implements MiddlewareInterface
{
    public function doGet(ServerRequestInterface $request,RequestHandlerInterface $handler){
        $handler->pipe(HtmlPresenter::present("front/index"));
        return $handler->handle($request);
    }
}
<?php

namespace App\modules\Front\Controllers;

use App\Services\Infrastructure\AbstractTypes\AbstractWebController;
use Oxygen\Providers\Presentation\HtmlPresenter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AboutController extends AbstractWebController implements MiddlewareInterface
{
   public function doGet(ServerRequestInterface $request,RequestHandlerInterface $handler){
       $handler->pipe(HtmlPresenter::present("front/about"));
       return $handler->handle($request);
   }
}
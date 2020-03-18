<?php

namespace App\Modules\Front\Controllers;

use Oxygen\AbstractTypes\AbstractWebController;
use Oxygen\Contracts\AppContract;
use Oxygen\Exceptions\RequestHandlerException;
use Oxygen\Providers\Presentation\HtmlPresenter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class ContactController extends AbstractWebController implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param AppContract $handler
     * @return ResponseInterface
     */
    public function doGet(ServerRequestInterface $request,AppContract $handler){
        return redirectBack($request);
    }
}
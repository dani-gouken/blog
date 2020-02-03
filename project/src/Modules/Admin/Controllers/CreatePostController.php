<?php

namespace App\Modules\Admin\Controllers;

use App\Actions\Post\ValidateCreatePost;
use Oxygen\AbstractTypes\AbstractWebController;
use Oxygen\Contracts\AppContract;
use Oxygen\Exceptions\RequestHandlerException;
use Oxygen\Providers\Presentation\HtmlPresenter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class CreatePostController extends AbstractWebController implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param AppContract $handler
     * @return ResponseInterface
     * @throws RequestHandlerException
     */
    public function doGet(ServerRequestInterface $request,AppContract $handler){
        $handler->pipe(HtmlPresenter::present("admin/post/create"));
        return $handler->handle($request);
    }
    public function doPost(ServerRequestInterface $request, AppContract $handler)
    {
        $handler->pipe(ValidateCreatePost::class);
        $handler->pipe(redirectRouteAction("front.home"));
        return $handler->handle($request);
    }
}
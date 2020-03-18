<?php

namespace App\Modules\Admin\Controllers;

use App\Actions\Post\CreatePost;
use App\Entities\Post;
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

    /**
     * @param ServerRequestInterface $request
     * @param AppContract $handler
     * @return ResponseInterface|void
     * @throws RequestHandlerException
     */
    public function doPost(ServerRequestInterface $request, AppContract $handler)
    {
        $handler->pipe(CreatePost::class);
        $handler->pipe();
        $handler->pipe(redirectRouteAction("post.index"));
        return $handler->handle($request);
    }
}
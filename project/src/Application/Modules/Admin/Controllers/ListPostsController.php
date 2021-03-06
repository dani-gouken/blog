<?php

namespace App\Modules\Admin\Controllers;

use Domain\Repositories\PostRepository;
use Oxygen\AbstractTypes\AbstractWebController;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Oxygen\Exceptions\RequestHandlerException;
use Oxygen\Providers\Presentation\HtmlPresenter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class ListPostsController extends AbstractWebController implements MiddlewareInterface
{
    /**
     * @var PostRepository
     */
    private $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param AppContract $handler
     * @return ResponseInterface
     * @throws RequestHandlerException
     */
    public function doGet(ServerRequestInterface $request,AppContract $handler){
        $handler->pipe(HtmlPresenter::present("admin/post/index",["posts" => $this->repository->findAll()]));
        return $handler->handle($request);
    }
}
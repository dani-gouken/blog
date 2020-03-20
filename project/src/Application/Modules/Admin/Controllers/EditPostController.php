<?php

namespace App\Modules\Admin\Controllers;

use App\Actions\Post\PersistPost;
use Domain\Entities\Post;
use Domain\Repositories\PostRepository;
use Oxygen\AbstractTypes\AbstractWebController;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Oxygen\Exceptions\RequestHandlerException;
use Oxygen\Providers\Presentation\HtmlPresenter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class EditPostController extends AbstractWebController implements MiddlewareInterface
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
        $matchedRoute = router()->getMatchedRoute($request);
        $post = $this->repository->find($matchedRoute->arguments["id"]);
        $handler->pipe(HtmlPresenter::present("admin/post/edit",["post"=>$post]));
        return $handler->handle($request);
    }

    public function doPost(ServerRequestInterface $request, AppContract $handler)
    {
        $matchedRoute = router()->getMatchedRoute($request);
        $post = $this->repository->find($matchedRoute->arguments["id"]);
        $handler->getContainer()->set(Post::class,$post);
        $handler->pipe(PersistPost::class);
        $handler->pipe(redirectRouteAction("post.index"));
        return $handler->handle($request);
    }
}
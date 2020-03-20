<?php

namespace App\Modules\Admin\Controllers;

use Domain\Repositories\PostRepository;
use Oxygen\AbstractTypes\AbstractWebController;
use Oxygen\Contracts\AppContract;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class DeletePostController extends AbstractWebController implements MiddlewareInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function doGet(ServerRequestInterface $request, AppContract $handler)
    {
        $matchedRoute = router()->getMatchedRoute($request);
        $post = $this->postRepository->find($matchedRoute->arguments["id"]);
        $this->postRepository->delete($post);
        return redirectBack($request);

    }
}
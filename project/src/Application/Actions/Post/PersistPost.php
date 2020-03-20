<?php


namespace App\Actions\Post;

use Domain\Entities\Post;
use Domain\Repositories\PostRepository;
use Oxygen\AbstractTypes\AbstractValidatedRequest;
use Oxygen\Contracts\AppContract;
use Oxygen\Providers\Session\FlashMessageManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class PersistPost extends AbstractValidatedRequest implements MiddlewareInterface
{
    /**
     * @var FlashMessageManager
     */
    private $flasher;
    /**
     * @var PostRepository
     */
    private $repository;
    /**
     * @var Post|null
     */
    private $post;

    public function __construct(FlashMessageManager $flasher,PostRepository $repository,?Post $post)
    {
        $this->flasher = $flasher;
        $this->repository = $repository;
        $this->post = $post;
    }


    public function rules(): array
    {
        return [
            "title"=>"required",
            "content"=>"required"
        ];
    }

    public function fails(array $error, ServerRequestInterface $request, AppContract $handler): ResponseInterface
    {
        $this->flasher->flash("errors",$error);
        return redirectBack($request);
    }

    public function passes(ServerRequestInterface $request, AppContract $handler): ResponseInterface
    {
        $data = $request->getParsedBody();
        if(!$this->post){
            $post = Post::newFromArray($data);
            $this->repository->create($post);
        }else{
            $this->post->setTitle($data["title"]);
            $this->post->setContent($data["content"]);
            $this->repository->update($this->post);
        }
        $this->flasher->flash("success","Post created");
        return $handler->handle($request);

    }
}
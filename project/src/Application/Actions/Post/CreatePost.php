<?php


namespace App\Actions\Post;

use App\Entities\Post;
use Oxygen\AbstractTypes\AbstractValidatedRequest;
use Oxygen\Contracts\AppContract;
use Oxygen\Providers\Session\FlashMessageManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class CreatePost extends AbstractValidatedRequest implements MiddlewareInterface
{
    /**
     * @var FlashMessageManager
     */
    private $flasher;

    public function __construct(FlashMessageManager $flasher)
    {
        $this->flasher = $flasher;
    }

    /**
     * @var FlashMessageManager
     */
    private $flash;

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
        $post = new Post();
        $data = $request->getParsedBody();
        $post->setTitle($data["title"]);
        $post->setContent($data["content"]);
    }
}
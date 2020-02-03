<?php


namespace App\Actions\Post;


use Oxygen\AbstractTypes\AbstractValidator;
use Oxygen\Contracts\AppContract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\TextResponse;
use Zend\Diactoros\ResponseFactory;

class ValidateCreatePost extends AbstractValidator implements MiddlewareInterface
{
    public function rules(): array
    {
        return [
            "title"=>"required|alpha_num",
            "content"=>"required"
        ];
    }

    public function fails(array $error, ServerRequestInterface $request, AppContract $handler): ResponseInterface
    {
        return new JsonResponse($error);
    }
}
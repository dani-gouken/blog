<?php


namespace Oxygen\AbstractTypes;


use Oxygen\Contracts\AppContract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Rakit\Validation\Validator;

abstract class AbstractValidator implements MiddlewareInterface
{
    protected $validator;
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->validator = new Validator();
        $validation = $this->validator->validate($_POST + $_FILES,$this->rules());
        if($validation->fails()){
            return $this->fails($validation->errors()->toArray(),$request,$handler);
        }
        return $handler->handle($request);
    }

    abstract public function rules():array;
    abstract public function fails(array $error,ServerRequestInterface $request,AppContract $handler):ResponseInterface;
}
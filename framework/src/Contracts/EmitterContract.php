<?php
namespace Oxygen\Contracts;

use Psr\Http\Message\ResponseInterface;

interface EmitterContract
{
    public function emit(ResponseInterface $response):void;
}

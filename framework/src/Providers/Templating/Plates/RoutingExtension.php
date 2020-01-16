<?php


namespace Oxygen\Providers\Templating\Plates;


use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Oxygen\Providers\Templating\RoutingExtensionTrait;

class RoutingExtension implements ExtensionInterface
{
    use RoutingExtensionTrait;
    public function register(Engine $engine)
    {
       foreach ($this->getAvailableMethods() as $method){
           $engine->registerFunction($method,[$this,$method]);
       }
    }
}
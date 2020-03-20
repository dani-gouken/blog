<?php


namespace Oxygen\Providers\Session\Extensions;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class PlatesExtension implements ExtensionInterface {
    use SessionExtensionTrait;
    public function register(Engine $engine)
    {
        foreach ($this->getAvailableMethods() as $method){
            $engine->registerFunction($method,[$this,$method]);
        }
    }
}
<?php


namespace Oxygen\Providers\Templating\Twig;
use Oxygen\Providers\Templating\RoutingExtensionTrait;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RoutingExtension extends AbstractExtension
{
    use RoutingExtensionTrait;
    public function getFunctions()
    {
        $functions = [];
        foreach ($this->getAvailableMethods() as $method){
            $functions[] = new TwigFunction($method,[$this,$method]);
        }
        return $functions;
    }

}
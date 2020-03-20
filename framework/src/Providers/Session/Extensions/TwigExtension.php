<?php


namespace Oxygen\Providers\Session\Extensions;


use Twig\Extension\AbstractExtension;

class TwigExtension extends AbstractExtension
{
    use SessionExtensionTrait;
    public function getFunctions()
    {
        $functions = [];
        foreach ($this->getAvailableMethods() as $method){
            $functions[] = new TwigFunction($method,[$this,$method]);
        }
        return $functions;
    }
}
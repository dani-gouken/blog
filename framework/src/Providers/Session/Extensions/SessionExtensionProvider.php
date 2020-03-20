<?php


namespace Oxygen\Providers\Session\Extensions;


use League\Plates\Engine;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Oxygen\Contracts\ServiceProviderContract;
use Twig\Environment;

class SessionExtensionProvider implements ServiceProviderContract
{

    public function register(AppContract $app)
    {
        $renderer = $app->getContainer()->get(RendererContract::class);
        if($renderer instanceof Environment){
            $renderer->addExtension(
                $app->getContainer()->get(TwigExtension::class)
            );
            return;
        }

        if($renderer instanceof Engine){
            $renderer->loadExtension(
                $app->getContainer()->get(PlatesExtension::class)
            );
            return;
        }
    }
}
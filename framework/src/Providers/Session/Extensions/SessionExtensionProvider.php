<?php


namespace Oxygen\Providers\Session\Extensions;


use League\Plates\Engine;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Oxygen\Contracts\ServiceProviderContract;
use Twig\Environment;

class ExtensionProvider implements ServiceProviderContract
{
    /**
     * @var RendererContract
     */
    private $renderer;

    public function __construct(RendererContract $renderer)
    {
        $this->renderer = $renderer;
    }

    public function register(AppContract $app)
    {
        if($this->renderer instanceof Environment){
            $this->renderer->addExtension(
                $app->getContainer()->get(TwigExtension::class)
            );
            return;
        }

        if($this->renderer instanceof Engine){
            $this->renderer->loadExtension(
                $app->getContainer()->get(PlatesExtension::class)
            );
            return;
        }
    }
}
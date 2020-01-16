<?php


namespace Oxygen\Providers\Templating\Twig;

use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Oxygen\Contracts\ServiceProviderContract;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigProvider implements ServiceProviderContract
{
    /**
     * @var string
     */
    private $cacheDir;
    /**
     * @var string
     */
    private $path;
    /**
     * @var array
     */
    private $options;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(string $cacheDir, string $path,$options = [])
    {
        $this->cacheDir = $cacheDir;
        $this->path = $path;
        $this->options = $options;
        $this->buildEnvironment();
    }

    public function buildEnvironment()
    {
        $loader = new FilesystemLoader($this->path);
        $twig = new DecoratedEnvironment($loader, array_merge([
            'cache' => $this->cacheDir,
        ],$this->options));
        $twig->addExtension(new RoutingExtension());
        $this->environment = $twig;
    }

    public function register(AppContract $app)
    {
        $app->getContainer()->set(RendererContract::class,$this->environment);
        $app->getContainer()->set(Environment::class,$this->environment);
    }
}
<?php


namespace Oxygen;

use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ContainerContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Decorators\DecoratedContainer;
use Oxygen\Providers\Configurator\ConfigProvider;
use Oxygen\Providers\Configurator\Configurator;
use Oxygen\Providers\Database\Doctrine\DoctrineProvider;
use Oxygen\Providers\Routing\RoutingProvider;
use Oxygen\Providers\Templating\Plates\PlatesProvider;
use Oxygen\Providers\Templating\Twig\TwigProvider;

class AppFactory
{
    /**
     * @var Configurator
     */
    public $config;
    /**
     * @var string
     */
    private const DS = DIRECTORY_SEPARATOR;
    /**
     * @var App
     */
    private $app;
    public function __construct(ContainerContract $container,array $configFiles)
    {
        $this->app = new App($container);
        $this->useConfig($configFiles);
    }



    private function appPath($path="")
    {
        return $this->config->get("app.path").self::DS.$path;
    }

    public static function createWithDefaultContainer($configFiles){
        return new self(new DecoratedContainer(),$configFiles);
    }

    public function useTwig(){
        $this->app->use(new TwigProvider(
            $this->config->get("app.cache.path").self::DS."twig",
            $this->config->get("app.views.folder"),
            $this->config->get("twig.options")
        ));
    }
    public function usePlates(){
        $this->app->use(new PlatesProvider(
            $this->config->get("app.views.folder"),
           $this->config->get("plates.folders",[]),
            $this->config->get("plates.file-extension","")
        ));
    }

    public function useDefaultRouter(string $host = ""){
        $this->app->use(new RoutingProvider());
    }

    public function getApp():AppContract{
        return $this->app;
    }

    private function getApplicationPath(){
        return getcwd();
    }

    public function use(ServiceProviderContract $service){
        $this->app->use($service);
    }
    public function useDoctrine(){
        $doctrineProvider = $this->app->get(DoctrineProvider::class);
        $this->app->use($doctrineProvider);
    }

    public function useConfig(array $configFiles)
    {
        $provider = new ConfigProvider($configFiles);
        $this->app->use($provider);
        $this->config = $this->app->getContainer()->get(Configurator::class);
    }
}
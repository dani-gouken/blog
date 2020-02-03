<?php


namespace Oxygen;

use Exception;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ContainerContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Decorators\DecoratedContainer;
use Oxygen\Providers\Configurator\ConfigProvider;
use Oxygen\Providers\Configurator\Configurator;
use Oxygen\Providers\Database\Doctrine\DoctrineProvider;
use Oxygen\Providers\Filesystem\DiskManagerProvider;
use Oxygen\Providers\Routing\RoutingProvider;
use Oxygen\Providers\Session\PhpSessionProvider;
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
    /**
     * @var ContainerContract
     */
    private $container;

    public function __construct(ContainerContract $container, string $path,array $configFiles)
    {
        $this->app = new App($container,$path);
        $this->useConfig($configFiles);
        $this->container = $container;
    }

    public static function createWithDefaultContainer(string $path,array $configFiles){
        return new self(new DecoratedContainer(),$path,$configFiles);
    }

    /**
     * @throws Exception
     */
    public function useTwig(){
        $this->app->use(new TwigProvider(
            $this->app->appPath($this->config->get("app.cache.path").self::DS."twig"),
            $this->config->get("app.views.folder"),
            $this->config->get("twig.options")
        ));
    }

    /**
     * @throws Exception
     */
    public function usePlates(){
        $this->app->use(new PlatesProvider(
            $this->app->appPath($this->config->get("app.views.folder")),
           $this->config->get("plates.folders",[]),
            $this->config->get("plates.file-extension","")
        ));
    }

    public function useDisks(array $disks){
        $this->app->use(new DiskManagerProvider($disks));
    }

    /**
     * @throws Exception
     */
    public function useDefaultRouter(){
        $host  = $this->config->get("app.host",null);
        $this->app->use(new RoutingProvider($host));
    }

    public function getApp():AppContract{
        return $this->app;
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

    public function usePhpSession(){
        $this->app->use(new PhpSessionProvider());
    }
}
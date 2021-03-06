<?php


namespace Oxygen\Providers\Configurator;


use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;

class ConfigProvider implements ServiceProviderContract
{
    /**
     * @var array
     */
    private $files;

    public function __construct(array $files)
    {
        $this->files = $files;
    }
    public function register(AppContract $app)
    {
        $instance = new Configurator();
        foreach ($this->files as $file){
            $instance->loadFile($app->appPath($file));
        }
        $app->getContainer()->set(Configurator::class,$instance);
    }
}
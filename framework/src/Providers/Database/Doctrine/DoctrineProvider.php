<?php


namespace Oxygen\Providers\Database\Doctrine;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Providers\Configurator\Configurator;

class DoctrineProvider implements ServiceProviderContract
{
    /**
     * @var Configurator
     */
    private $config;

    private $connections;

    public function __construct(Configurator $config)
    {
        $this->config = $config;
    }

    public function register(AppContract $app)
    {
        $connections = $this->config->get("doctrine.connections");
        $isDevMode = $this->config->get("doctrine.isDevMode",false);
        $entitiesPath = $this->config->get("doctrine.entities.path");
        $config = Setup::createAnnotationMetadataConfiguration($entitiesPath, $isDevMode);
        if(!array_key_exists("default",$connections)){
            throw new \Exception("You need a [default] doctrine connection in your configuration!");
        }
        $entityManager = EntityManager::create($connections["default"], $config);
        $app->set(EntityManager::class,$entityManager);
    }


}
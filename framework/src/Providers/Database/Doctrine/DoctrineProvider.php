<?php


namespace Oxygen\Providers\Database\Doctrine;


use Doctrine\Common\Persistence\Mapping\Driver\PHPDriver;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\AbstractFileConfiguration;
use Doctrine\Migrations\Configuration\ArrayConfiguration;
use Doctrine\Migrations\Configuration\Exception\InvalidConfigurationKey;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Providers\Configurator\Configurator;
use Oxygen\Providers\Console\Console;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\Migrations\Configuration\Configuration;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

class DoctrineProvider implements ServiceProviderContract
{
    /**
     * @var Configurator
     */
    private $config;
    private $builder;
    private $connection = null;

    public function __construct(Configurator $config, ?callable $builder = null)
    {
        $this->config = $config;
        $this->builder = $builder;
    }
    private function getConnection(){
        if($this->connection == null){
            $connections = $this->config->get("doctrine.connections");
            $activeConnection = $this->config->get("doctrine.connection");
            $connectionArgs = $connections[$activeConnection] ?? "default";
            $connection = DriverManager::getConnection($connectionArgs);
            $this->connection = $connection;
        }
        return $this->connection;

    }

    /**
     * @param AppContract $app
     */
    public function register(AppContract $app)
    {
        $builder = $this->builder;
        $em = $builder != null ? $builder() : $this->buildEntityManager($app);
        $app->getContainer()->set(EntityManager::class, $em);
        if ($app->getContainer()->get(Console::class) && $this->config->get("doctrine.console.active", false)) {
            $em = $app->getContainer()->get(EntityManager::class);
            $console = $app->getContainer()->get(Console::class);
            $this->addMigrationCommand($console,$app,$em);
            ConsoleRunner::addCommands($console->getApplication());
        }
    }

    private function buildEntityManager(AppContract $app): EntityManager
    {
        $isDevMode = $this->config->get("doctrine.isDevMode", false);
        $entitiesPath = $this->config->get("doctrine.entities.path");
        $phpMappingFilesFolder = $this->config->get("doctrine.php.mapping.path", $app->appPath("src".DIRECTORY_SEPARATOR.
            "Infrastructure" . DIRECTORY_SEPARATOR .
            "Persistence" . DIRECTORY_SEPARATOR . "Doctrine" .
            DIRECTORY_SEPARATOR . "Mapping"
        ));
        $driver = new PHPDriver($phpMappingFilesFolder);
        $config = Setup::createAnnotationMetadataConfiguration($entitiesPath, $isDevMode);
        $config->setEntityNamespaces(["App\Domain\Entities"]);
        $entityManager = EntityManager::create($this->getConnection(), $config);
        $entityManager->getConfiguration()->setMetadataDriverImpl($driver);
        return $entityManager;
    }

    private function addMigrationCommand(Console $console,AppContract $app,EntityManager $em)
    {
        $configuration = new Configuration($this->getConnection());
        $configuration->setName('Migrations');
        $configuration->setMigrationsNamespace('Infrastructure\Persistence\Doctrine\Migrations');
        $configuration->setMigrationsTableName('doctrine_migration_versions');
        $configuration->setMigrationsColumnName('version');
        $configuration->setMigrationsColumnLength(255);
        $configuration->setMigrationsExecutedAtColumnName('executed_at');
        $configuration->setMigrationsDirectory($app->appPath("src/Infrastructure/Persistence/Doctrine/Migrations"));

        $helperSet = ConsoleRunner::createHelperSet($em);
        $helperSet->set(new QuestionHelper(), 'question');
        $helperSet->set(new ConnectionHelper($this->getConnection()), 'db');
        $helperSet->set(new ConfigurationHelper($this->getConnection(), $configuration));
        $console->getApplication()->setHelperSet($helperSet);

        $console->getApplication()->addCommands(array(
            new Command\DumpSchemaCommand(),
            new Command\ExecuteCommand(),
            new Command\GenerateCommand(),
            new Command\LatestCommand(),
            new Command\MigrateCommand(),
            new Command\RollupCommand(),
            new Command\StatusCommand(),
            new Command\VersionCommand(),
            new DiffCommand()

    ));
    }

}
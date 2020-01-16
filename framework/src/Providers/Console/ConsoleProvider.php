<?php


namespace Oxygen\Providers\Console;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Providers\Console\Commands\Modules\ListModulesCommand;
use Oxygen\Providers\Console\Commands\Modules\MakeModuleCommand;
use Oxygen\Providers\Console\Commands\Routing\ListRoutesCommand;
use Oxygen\Providers\Console\Commands\ServeCommands;

class ConsoleProvider implements ServiceProviderContract
{

    public function register(AppContract $app)
    {
       $app->getContainer()->set(Console::class,$this->buildApplication($app));
    }

    private function buildApplication(AppContract $app):Console
    {
        $application = new Console([
            $app->get(ListRoutesCommand::class),
            new ListModulesCommand($app),
            $app->get(ServeCommands::class),
            $app->get(MakeModuleCommand::class)
        ]);
        if ($app->has(EntityManager::class)){
            $em = $app->get(EntityManager::class);
            $application->getApplication()->setHelperSet(
               ConsoleRunner::createHelperSet($em)
            );
            \Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($application->getApplication());

        }
        return $application;
    }
}
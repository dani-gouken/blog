<?php


namespace Oxygen\Providers\Console;

use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Providers\Configurator\Configurator;
use Oxygen\Providers\Console\Commands\Modules\ListModulesCommand;
use Oxygen\Providers\Console\Commands\Modules\MakeControllerCommand;
use Oxygen\Providers\Console\Commands\Modules\MakeModuleCommand;
use Oxygen\Providers\Console\Commands\Routing\ListRoutesCommand;
use Oxygen\Providers\Console\Commands\ServeCommands;

class ConsoleProvider implements ServiceProviderContract
{

    public function register(AppContract $app)
    {
        $app->getContainer()->set(Console::class, $this->buildApplication($app));
    }

    private function buildApplication(AppContract $app): Console
    {
        $configurator = $app->getContainer()->get(Configurator::class);
        $publicPath = $configurator->get("public.path", $app->appPath("public"));
        $application = new Console([
            $app->get(ListRoutesCommand::class),
            new ListModulesCommand($app),
            new ServeCommands($publicPath),
            new MakeControllerCommand(),
            $app->get(MakeModuleCommand::class)
        ]);
        return $application;
    }
}
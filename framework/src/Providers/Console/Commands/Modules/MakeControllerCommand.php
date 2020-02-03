<?php


namespace Oxygen\Providers\Console\Commands\Modules;


use League\Flysystem\FileExistsException;
use Oxygen\Providers\Filesystem\DiskManagerException;
use Oxygen\Providers\Filesystem\DiskNotFoundException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeControllerCommand extends Command
{
    public static $defaultName = "make:controller";
    protected function configure()
    {
        $this->setDescription('Generate a controller for a module');
        $this->addArgument("controller",InputArgument::REQUIRED,"The name of the controller");
        $this->addArgument(
            "module",
            InputArgument::REQUIRED,
            "The module that has the controller");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws FileExistsException
     * @throws DiskManagerException
     * @throws DiskNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output){
        $moduleName = ucfirst($input->getArgument("module"));
        $controllerName = ucfirst($input->getArgument("controller"));
        if($controllerName != "Controller"){
            $controllerName = str_replace("Controller","",$controllerName);
        }
        $configurator = config();
        $localDisk = disks()->get("local");
        $modulePath = $configurator->get("app.module.path",
            "src".DIRECTORY_SEPARATOR."Modules");
        $modulePath.= DIRECTORY_SEPARATOR.$moduleName;

        if(!$localDisk->has($modulePath)){
            $output->writeln("The module [$moduleName] doesn't exists");
            return 0;
        }
        $controllerPath = $modulePath.DIRECTORY_SEPARATOR."Controllers".DIRECTORY_SEPARATOR.$controllerName."Controller.php";
        if($localDisk->has($controllerPath)){
            $output->writeln("The controller [$controllerName] already exists");
        }
        $localDisk->write($controllerPath,$this->getTemplate($controllerName,ucfirst($moduleName)));
        $output->writeln("The controller [$controllerName] was successfully created on [$controllerPath]");
        return 0;
    }

    private function getTemplate(string $controllerName,string $moduleName)
    {
        $controllerNameLowerCase = strtolower($controllerName);
        //$controllerNameSpace = "App\Modules\\".$controllerName;
        $moduleNameLowerCase = strtolower($moduleName);
        $controllerClassname = $controllerName."Controller";
        return <<<EOT
<?php

namespace App\Modules\\$moduleName\Controllers;

use Oxygen\AbstractTypes\AbstractWebController;
use Oxygen\Contracts\AppContract;
use Oxygen\Exceptions\RequestHandlerException;
use Oxygen\Providers\Presentation\HtmlPresenter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class $controllerClassname extends AbstractWebController implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface \$request
     * @param AppContract \$handler
     * @return ResponseInterface
     * @throws RequestHandlerException
     */
    public function doGet(ServerRequestInterface \$request,AppContract \$handler){
        \$handler->pipe(HtmlPresenter::present("$moduleNameLowerCase/$controllerNameLowerCase"));
        return \$handler->handle(\$request);
    }
}
EOT;

    }


}
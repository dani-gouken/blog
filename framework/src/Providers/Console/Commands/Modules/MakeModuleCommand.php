<?php

namespace Oxygen\Providers\Console\Commands\Modules;

use Oxygen\Providers\Configurator\Configurator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModuleCommand extends Command
{
    /**
     * @var Configurator
     */
    private $config;

    public function __construct(Configurator $config)
    {

        parent::__construct();
        $this->config = $config;
    }

    protected static $defaultName = "make:module";

    protected function configure()
    {
        $this->addArgument("module",InputArgument::REQUIRED,"Name of the module");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moduleName = $input->getArgument("module");
        $appPath = $this->config->get("app.path");
        $modulePath = $this->config->get("app.module.path",$appPath.DIRECTORY_SEPARATOR."Modules");
        $modulePath.= DIRECTORY_SEPARATOR.$moduleName;
        if (file_exists($modulePath)){
            $output->writeln("Module already exists on [$modulePath]");
            return 0;
        }
        mkdir($modulePath);
        $fileName = ucfirst($moduleName)."Module.php";
        file_put_contents($modulePath.DIRECTORY_SEPARATOR.$fileName,$this->getTemplate($moduleName));
        $output->writeln($modulePath);
        return 0;
    }

    private function getTemplate(string $moduleName){
        $moduleName = ucfirst($moduleName);
        $moduleNameSpace = "App\Modules\\".$moduleName;
        $moduleClassname = $moduleName."Module";
        return <<<EOT
<?php


namespace $moduleNameSpace;

use App\Modules\AbstractModule;
use Oxygen\Contracts\ContainerContract;
use Oxygen\Providers\Routing\Route;
use Oxygen\Providers\Routing\RouteGroup;
use Oxygen\Providers\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class $moduleClassname extends AbstractModule implements MiddlewareInterface
{
    public \$MODULE_NAME="$moduleName";
    public \$MODULE_DESCRIPTION ="$moduleName module";

    protected function addRoutes(Router \$router)
    {
     
    }

    protected function addDependencies(ContainerContract \$container)
    {
    }

    protected function setUp(ServerRequestInterface \$request, RequestHandlerInterface \$handler)
    {
    }
}
EOT;

    }

}
<?php


namespace Oxygen\Providers\Console\Commands\Modules;


use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ModuleContract;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListModulesCommand extends Command
{

    public static $defaultName="list:modules";
    /**
     * @var AppContract
     */
    private $app;

    public function __construct(AppContract $app)
    {
        $this->app = $app;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('List all modules the application');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $modules = $this->getModules();
        if(!empty($modules)){
            $table->setHeaderTitle('Modules');
            $table->setHeaders(['Name', 'Class','Description']);
            $table->setRows($modules);
            $table->render();
            return 0;
        }
        $output->writeln("<error>No module found</error>");
        return 0;
    }

    private function getModules():array
    {
        $middlewares = $this->app->getMiddlewares();
        $modules = [];
        foreach ($middlewares as $middleware){
            if(is_string($middleware)){
                $concrete = $this->app->get($middleware);
            }else{
                $concrete = $middleware;
            }
            if($concrete instanceof ModuleContract){
                $modules[] = [
                    $concrete->getModuleName(),
                    get_class($concrete),
                    $concrete->getModuleDescription()
                ];
            }
        }
        return $modules;
    }

}
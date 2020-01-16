<?php


namespace Oxygen\Providers\Console\Commands;


use Oxygen\Providers\Configurator\Configurator;
use PHPUnit\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommands extends Command
{
    protected static $defaultName = 'serve';
    /**
     * @var Configurator
     */
    private $configurator;

    public function __construct(Configurator $configurator)
    {
        $this->configurator = $configurator;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Serve the application');
        $this->addArgument("port",InputArgument::OPTIONAL,"serve port");
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getArgument("port") ?? 8000;
        try{
            $appPath = $this->configurator->get("app.path");
            $defaultPublicPath = dirname(dirname($appPath."/public"));
            $publicPath = $this->configurator->get("public.path",$defaultPublicPath)."/public";
            $version = $this->getApplication()->getVersion();
            $output->writeln("Oxygen Please CLI v$version");
            $output->writeln(">> Application serve on port $port");
            exec("php -S localhost:$port -t $publicPath");
        }catch (\Exception $e){
            $output->writeln($e->getMessage());
        }
        return 0;
    }

}
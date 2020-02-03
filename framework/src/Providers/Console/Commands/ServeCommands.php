<?php


namespace Oxygen\Providers\Console\Commands;


use Oxygen\Providers\Configurator\Configurator;
use PHPUnit\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ServeCommands extends Command
{
    protected static $defaultName = 'serve';
    private $servePath;
    /**
     * @var Configurator
     */

    public function __construct(string $servePath)
    {
        $this->servePath =  $servePath;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Serve the application');
        $this->addOption("port","p",
            InputOption::VALUE_OPTIONAL,
            "The port where you want to serve",
            "8000"
        );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getOption("port");
        try{
            $publicPath = $this->servePath;
            $version = $this->getApplication()->getVersion();
            $output->writeln("Oxygen Please CLI v$version");
            $output->writeln(">> Application serve on port $port");
            exec("php -S localhost:$port -t $publicPath");
        }catch (\Exception $e){
            $output->writeln($e->getMessage()."\n ".$e->getTraceAsString());
        }
        return 0;
    }

}
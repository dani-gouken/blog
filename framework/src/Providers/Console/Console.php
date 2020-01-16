<?php


namespace Oxygen\Providers\Console;
use Symfony\Component\Console\Application;


class Console
{
    private const APP_NAME = "Oxygen Please";
    private const version = "1.0.0";
    /**
     * @var array
     */
    private $commands;
    private $application;

    public function __construct(array $commands=[])
    {

        $this->commands = $commands;
        $this->application =  new Application(self::APP_NAME,self::version);
        $this->application->addCommands($commands);
    }

    public function getApplication(){
        return $this->application;
    }


}
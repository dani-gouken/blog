<?php


namespace Oxygen\Providers\Session;


use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\SessionManagerContract;
use Oxygen\Contracts\ServiceProviderContract;

class PhpSessionProvider implements ServiceProviderContract
{

    /**
     * @var PhpSessionManager
     */
    private $instance;

    public function __construct()
    {
        $this->instance = new PhpSessionManager();
    }

    public function register(AppContract $app)
    {
        if(!$this->sessionHasStarted()){
            session_start();
        }
        $app->getContainer()->set(PhpSessionManager::class,$this->instance);
        $app->getContainer()->set(SessionManagerContract::class,$this->instance);
    }

    private function sessionHasStarted(){
        return session_status() == PHP_SESSION_ACTIVE;
    }
}
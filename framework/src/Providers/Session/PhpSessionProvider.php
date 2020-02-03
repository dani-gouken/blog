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
        $app->getContainer()->set(PhpSessionManager::class,$this->instance);
        $app->getContainer()->set(SessionManagerContract::class,$this->instance);
    }
}
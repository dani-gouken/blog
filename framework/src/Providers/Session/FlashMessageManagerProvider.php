<?php


namespace Oxygen\Providers\Session;


use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;

class FlashMessageManagerProvider implements ServiceProviderContract
{

    public function register(AppContract $app)
    {
        $app->getContainer()->set(FlashMessageManager::class,
            $app->getContainer()->get(FlashMessageManager::class)
        );
    }
}
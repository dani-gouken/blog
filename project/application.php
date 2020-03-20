<?php

use App\Main;
use Infrastructure\ErrorHandling\ErrorHandlerProvider;
use Oxygen\AppFactory;
use Oxygen\Contracts\AppContract;
use Oxygen\Exceptions\RequestHandlerException;
use Oxygen\Providers\Filesystem\Disks\Local;
use Oxygen\Providers\Routing\Middlewares\RoutingMiddleware;
use Oxygen\Providers\Session\Extensions\SessionExtensionProvider;
use Oxygen\Providers\Session\FlashMessageManagerProvider;

require_once "vendor/autoload.php";
/**
 * @return AppContract
 * @throws RequestHandlerException
 * @throws Exception
 */
function main()
{
    $appFactory = AppFactory::createWithDefaultContainer(__DIR__, [
        "/config/config.php",
        "/config/twig.php",
        "/config/doctrine.php",
        "/config/plates.php",
    ]);


    $appFactory->usePlates();
    $appFactory->useDefaultRouter();
    $appFactory->usePhpSession();
    $appFactory->useDisks([
        new Local(__DIR__)
    ]);
    $app = $appFactory->getApp();

    $app->use(new FlashMessageManagerProvider());
    $app->use(new SessionExtensionProvider());

    $app->use(new ErrorHandlerProvider());
    $app->pipe(Main::class);
    $app->pipe(RoutingMiddleware::class);
    return $app;
}

return main();


<?php

use App\Main;
use App\Services\ErrorHandling\ErrorHandlerProvider;
use Oxygen\AppFactory;
use Oxygen\Providers\Filesystem\Disks\Local;
use Oxygen\Providers\Routing\Middlewares\RoutingMiddleware;

require_once "vendor/autoload.php";
$appFactory = AppFactory::createWithDefaultContainer(__DIR__, [
    "/config/config.php",
    "/config/twig.php",
    "/config/doctrine.php",
    "/config/plates.php",
]);

$appFactory->usePlates();
$appFactory->useDefaultRouter();
$appFactory->useDoctrine();
$appFactory->usePhpSession();
$appFactory->useDisks([
   new Local(__DIR__)
]);

$app = $appFactory->getApp();
$app->use(new ErrorHandlerProvider());
$app->pipe(Main::class);
$app->pipe(RoutingMiddleware::class);
return $app;
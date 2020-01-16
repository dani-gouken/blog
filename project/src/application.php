<?php

use App\Main;
use App\Services\ErrorHandling\ErrorHandlerProvider;
use Oxygen\AppFactory;
use Oxygen\Providers\Routing\Middlewares\RoutingMiddleware;

require_once "../vendor/autoload.php";

$appFactory = AppFactory::createWithDefaultContainer([
    __DIR__."/config/config.php",
    __DIR__."/config/twig.php",
    __DIR__."/config/doctrine.php",
    __DIR__."/config/plates.php",
]);

$appFactory->usePlates();
$appFactory->useDefaultRouter();
$appFactory->useDoctrine();

$app = $appFactory->getApp();
$app->use(new ErrorHandlerProvider());
$app->pipe(Main::class);
$app->pipe(RoutingMiddleware::class);
return $app;
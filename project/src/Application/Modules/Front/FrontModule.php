<?php


namespace App\Modules\Front;

use App\modules\Front\Controllers\AboutController;
use App\Modules\Front\Controllers\ContactController;
use App\Modules\Front\Controllers\IndexController;
use Oxygen\AbstractTypes\AbstractModule;
use Oxygen\Contracts\AppContract;
use Oxygen\Providers\Routing\Route;
use Oxygen\Providers\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class FrontModule extends AbstractModule implements MiddlewareInterface
{
    public $MODULE_NAME="Front Module";
    public $MODULE_DESCRIPTION ="All Front end Components";

    protected function addRoutes(Router $router)
    {
        $router->add(Route::get(
            "/",
            "front.home",
            IndexController::class
        ));

        $router->add(Route::get(
            "/about",
            "front.about",
            AboutController::class
        ));

        $router->add(Route::get(
            "/contact",
            "front.contact",
            ContactController::class
        ));
    }

    protected function setUp(ServerRequestInterface $request, AppContract $app)
    {

    }
}
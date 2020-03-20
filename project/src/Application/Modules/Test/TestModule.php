<?php
namespace App\Modules\Test;

use App\Modules\Front\Controllers\IndexController;
use Oxygen\AbstractTypes\AbstractModule;
use Oxygen\Contracts\Providers\Routing\RouteGroupContract;
use Oxygen\Providers\Routing\Route;
use Oxygen\Providers\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Oxygen\Contracts\AppContract;

class TestModule extends AbstractModule implements MiddlewareInterface
{
    public $MODULE_NAME="Test";
    public $MODULE_DESCRIPTION ="Test module";

    protected function addRoutes(Router $router)
    {

        $router->group("test",function(RouteGroupContract $group){
            $group->add(Route::get(
                "/test",
                "test.home",
                IndexController::class
            ));
        });
    }

    protected function setUp(ServerRequestInterface $request, AppContract $app)
    {
    }
}
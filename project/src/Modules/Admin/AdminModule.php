<?php
namespace App\Modules\Admin;

use App\Modules\Admin\Controllers\CreatePostController;
use App\Modules\Admin\Controllers\DeletePostController;
use App\Modules\Admin\Controllers\EditPostController;
use App\Modules\Admin\Controllers\ListPostsController;
use Oxygen\AbstractTypes\AbstractModule;
use Oxygen\Providers\Routing\Route;
use Oxygen\Providers\Routing\RouteGroup;
use Oxygen\Providers\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Oxygen\Contracts\AppContract;

class AdminModule extends AbstractModule implements MiddlewareInterface
{
    public $MODULE_NAME="Admin";
    public $MODULE_DESCRIPTION ="Admin module";

    protected function addRoutes(Router $router)
    {
        $router->group("/admin",function(RouteGroup $group){
            $group->add(Route::get("/post","post.index",ListPostsController::class));
            $group->add(Route::create(["GET","POST"],"/post/create","post.create",CreatePostController::class));
            $group->add(Route::create(["GET","POST"],"/post/edit/{id:\d+}","post.edit",EditPostController::class));
            $group->add(Route::post("/post/delete/{id:\d+}","post.delete",DeletePostController::class));
        });
    }

    protected function setUp(ServerRequestInterface $request, AppContract $app)
    {
    }
}
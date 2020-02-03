<?php
require_once __DIR__."../../vendor/autoload.php";

use League\Flysystem\AdapterInterface;
use Oxygen\Actions\Routing\Redirect;
use Oxygen\Actions\Routing\RedirectBack;
use Oxygen\Actions\Routing\RedirectRoute;
use Oxygen\App;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ContainerContract;
use Oxygen\Contracts\Providers\Routing\RouterContract;
use Oxygen\Contracts\Providers\SessionManagerContract;
use Oxygen\Providers\Configurator\Configurator;
use Oxygen\Providers\Filesystem\DiskManager;
use Oxygen\Providers\Filesystem\DiskManagerException;
use Oxygen\Providers\Filesystem\DiskNotFoundException;
use Oxygen\Providers\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Diactoros\Response\RedirectResponse;

if (!function_exists("disks")){
    /**
     * @param string|null $label
     * @return DiskManager | AdapterInterface
     * @throws DiskManagerException
     * @throws DiskNotFoundException
     */
    function disks(string $label = null):DiskManager{
        if(!$label){
            return DiskManager::instance();
        }
        return DiskManager::disk($label);
    }
}

if(!function_exists("router")){
    /**
     * @return RouterContract
     */
    function router(): RouterContract{
        return Router::$instance;
    }
}
if(!function_exists("session")){
    /**
     * @return SessionManagerContract
     */
    function session(): SessionManagerContract{
        return container()->get(SessionManagerContract::class);
    }
}

if(!function_exists("app")){
    /**
     * @return AppContract
     */
    function app(): AppContract{
        return App::$instance;
    }
}

if(!function_exists("container")){
    /**
     * @return ContainerContract
     */
    function container(): ContainerContract{
        return \app()->getContainer();
    }
}

if(!function_exists("appPath")){
    /**
     * @param string|null $path
     * @return ContainerContract
     */
    function appPath(string $path = null): string{
        return \app()->appPath($path);
    }
}

if(!function_exists("config")){
    function config():Configurator{
        return container()->get(Configurator::class);
    }
}

if(!function_exists("redirect")){
    function redirect(string $uri,int $status = 302,$headers = []): ResponseInterface{
        return new RedirectResponse($uri,$status,$headers);
    }
}

if(!function_exists("redirectRoute")){
    function redirectRoute(string $routeName,array $data = [],int $status = 302,$headers = []): ResponseInterface{
        $uri = \router()->generateUrl($routeName,$data);
        return redirect($uri,$status,$headers);
    }
}

if(!function_exists("redirectBack")){
    function redirectBack(ServerRequestInterface $request, int $status = 302, $headers = []): ResponseInterface{
        $uri = $request->getServerParams()["HTTP_REFERER"] ?? "/";
        return redirect($uri,$status,$headers);
    }
}

if(!function_exists("redirectAction")){
    function redirectAction(string $uri,int $status = 302,$headers = []): MiddlewareInterface{
        return new Redirect($uri,$status,$headers);
    }
}

if(!function_exists("redirectRouteAction")){
    function redirectRouteAction(string $routeName,array $data = [],int $status = 302,$headers = []): MiddlewareInterface{
        return new RedirectRoute($routeName,$data,$status,$headers);
    }
}

if(!function_exists("redirectBackAction")){
    function redirectBackAction(int $status = 302, $headers = []): MiddlewareInterface{
       return new RedirectBack($status,$headers);
    }
}
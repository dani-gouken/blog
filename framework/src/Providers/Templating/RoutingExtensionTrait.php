<?php

namespace Oxygen\Providers\Templating;
use Oxygen\App;
use Oxygen\Exceptions\Routing\RouteNotFoundException;
use Oxygen\Providers\Routing\Router;

trait RoutingExtensionTrait
{
    /**
     * @param $name
     * @param array $data
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function route($name,$data=[])
    {
        return Router::pathFor($name, $data);
    }

    public function asset(string $url){
        return Router::$instance->asset($url);
    }

    public function getAvailableMethods(){
        return array_filter(get_class_methods(RoutingExtensionTrait::class),function($item){
            return $item != "getAvailableMethods";
        });
    }
}
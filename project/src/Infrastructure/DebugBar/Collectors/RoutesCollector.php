<?php


namespace Infrastructure\DebugBar\Collectors;


use DebugBar\DataCollector\MessagesCollector;
use Oxygen\Providers\Routing\Router;

class RoutesCollector extends MessagesCollector
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        parent::__construct("routes");
        $this->router = $router;
    }

    public function collect()
    {
        $count = 0;
        foreach ($this->router->getRoutes() as $route) {
            $methods = implode(",",$route->getMethods());
            $count++;
            $this->addMessage($route->getName()." ({$methods})"."  ~  \" {$route->getPattern()}\"",$route->getMiddleware()." \"");
        }

        foreach ($this->router->getRouteGroups() as $routeGroups){
            foreach ($routeGroups->getRoutes() as $route){
                $methods = implode(",",$route->getMethods());
                $url = $routeGroups->getPattern().$route->getPattern();
                $count++;
                $this->addMessage($route->getName()." ({$methods})"."  ~  \" $url",$route->getMiddleware()." \"");
            }
        }
        return [
            'count' => $count,
            'messages' => $this->getMessages(),
        ];
    }

    function getName()
    {
        return "Routes";
    }

    public function getWidgets()
    {
        $widgets = parent::getWidgets();
        $widgets['models']['icon'] = 'cubes';
        return $widgets;
    }

}
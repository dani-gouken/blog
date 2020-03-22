<?php


namespace Infrastructure\DebugBar\Collectors;


use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\Renderable;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareCollector extends MessagesCollector implements Renderable
{

    private $middlewares = [];
    private $index = 1;
    public function addMiddleware(MiddlewareInterface $middleware){
        $this->middlewares[get_class($middleware)] = "$this->index -".get_class($middleware);
        $this->index ++;
    }
    function collect()
    {
        foreach ($this->middlewares as $index => $middleware) {
            $this->addMessage($middleware,$index);
        }
        return [
            'count' => count($this->middlewares),
            'messages' => $this->getMessages(),
        ];
    }

    function getName()
    {
        return "Middlewares";
    }

    public function getWidgets()
    {
        $widgets = parent::getWidgets();
        $widgets['models']['icon'] = 'cubes';
        return $widgets;
    }

}
<?php


namespace Infrastructure\DebugBar\Collectors;


use DebugBar\DataCollector\DataCollectorInterface;

class RouteCollector implements DataCollectorInterface
{

    function collect()
    {
        return ["LOLE"=>"BLABLA"];
    }

    /**
     * Returns the unique name of the collector
     *
     * @return string
     */
    function getName()
    {
        return "Routes";
    }
}
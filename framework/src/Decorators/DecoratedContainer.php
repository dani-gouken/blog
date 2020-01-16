<?php

namespace Oxygen\Decorators;

use ExpressiveDIC\DIC;
use ExpressiveDIC\Exceptions\InvalidArgumentException;
use Oxygen\Contracts\ContainerContract;

class DecoratedContainer extends DIC implements ContainerContract{
    /**
     * @param string $abstract
     * @param $concrete
     * @throws InvalidArgumentException
     */
    public function set(string $abstract, $concrete)
    {
        $this->describeValue($abstract,$concrete);
    }
}
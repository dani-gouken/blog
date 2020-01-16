<?php
namespace Oxygen\Contracts;

use Psr\Container\ContainerInterface;

interface ContainerContract extends ContainerInterface
{
    public function set (string $abstract,$concrete);
}

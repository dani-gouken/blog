<?php


namespace Oxygen\Contracts\Providers\Filesystem;


use League\Flysystem\AdapterInterface;

interface DiskContract
{
    public function getAdapter():AdapterInterface;
    public function getLabel():string;
    public function getConfig():?array;

}
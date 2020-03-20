<?php

namespace Oxygen\Providers\Configurator;

use InvalidArgumentException;

class Configurator
{
    private $config = [];

    /**
     * @param string $key
     * @param $value
     * @return Configurator
     */
    public function set(string $key,$value){
        $this->config[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key,$default=null){
        if(!array_key_exists($key,$this->config) && is_null($default)){
            throw new InvalidArgumentException("Cannot resolve key [$key] in configuration");
        }
        return $this->config[$key] ?? $default;
    }
    public function loadFile(string $path){
        $data = require_once($path);
        if (!is_array($data)){
            throw new InvalidArgumentException("the configuration file [$path] is invalid");
        }
        $this->load($data);
    }

    private function load(array $data)
    {
        $this->config = array_merge($this->config,$data);
    }
}
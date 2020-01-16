<?php

namespace Oxygen\Providers\Configurator;

use PHPUnit\Exception;

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
     * @throws \Exception
     */
    public function get(string $key,$default=null){
        if(!array_key_exists($key,$this->config) && is_null($default)){
            throw new \Exception("Cannot resolve key [$key] in configuration");
        }
        return $this->config[$key] ?? $default;
    }
    public function loadFile(string $path){
        $data = require_once($path);
        if (!is_array($data)){
            throw new \Exception("the configuration file [$path] is invalid");
        }
        $this->load($data);
    }

    private function load(array $data)
    {
        $this->config = array_merge($this->config,$data);
    }
}
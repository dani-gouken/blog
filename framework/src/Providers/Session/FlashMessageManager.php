<?php


namespace Oxygen\Providers\Session;


use Oxygen\Contracts\Providers\SessionManagerContract;

class Flash
{
    private $cache = [];
    /**
     * @var SessionManagerContract
     */
    private $session;

    private $flashKey = "_flash_messages";

    public $instance;

    public function __construct(SessionManagerContract $session)
    {
        $this->cache = $this->session->all();
        $this->session = $session;
        $this->instance = $this;
        $this->cache = $this->getSessionFlashes();
        $this->unsetLastSessionAndGenerateNewOne();
    }

    public function flash(string $type,$message):void{
        $flashes = $this->getSessionFlashes();
        $this->session->set($message,array_merge(
            $flashes,
            [$type=>$message]
        ));
    }

    public function get(?string $key=null){
        if(!$key){
            return $this->cache;
        }
        if(array_key_exists($key,$this->cache)){
            return $this->cache[$key];
        }
        return null;
    }

    private function getSessionFlashes(){
        return $this->session->get($this->flashKey,[])[$this->flashKey] ?? [];
    }

    private function unsetLastSessionAndGenerateNewOne(){
        $this->session->set($this->flashKey,[]);
    }

}
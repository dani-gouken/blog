<?php


namespace Oxygen\Providers\Session;


use Oxygen\Contracts\Providers\SessionManagerContract;

class PhpSessionManager implements SessionManagerContract
{
    public function __construct()
    {
        if(!$this->sessionHasStarted() && php_sapi_name() != "cli"){
            session_start();
        }
    }

    private function sessionHasStarted(){
        return session_status() == PHP_SESSION_ACTIVE;
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function unset(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function has(string $key)
    {
        array_key_exists($key,$_SESSION);
    }

    public function regenerate(string $key)
    {
        session_regenerate_id();
    }
}
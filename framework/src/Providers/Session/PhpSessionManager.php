<?php


namespace Oxygen\Providers\Session;


use Oxygen\Contracts\Providers\SessionManagerContract;

class PhpSessionManager implements SessionManagerContract
{
    public function __construct()
    {
        if(!$this->sessionHasStarted()){
            session_start();
        }
    }

    private function sessionHasStarted(){
        return session_status() == PHP_SESSION_ACTIVE;
    }

    public function get(string $key,$default = null)
    {
        if(!$this->has($key)){
            return $default;
        }
        return $_SESSION[$key];
    }

    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function unset(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function has(string $key):bool
    {
        return array_key_exists($key,$_SESSION);
    }

    public function regenerate()
    {
        session_regenerate_id();
    }

    public function all(): array
    {
        return $_SESSION ?? [];
    }

    public function clear()
    {
        unset($_SESSION);
    }
}
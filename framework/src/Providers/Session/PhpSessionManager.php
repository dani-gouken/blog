<?php


namespace Oxygen\Providers\Session;


use Oxygen\Contracts\Providers\SessionManagerContract;

class PhpSessionManager implements SessionManagerContract
{

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
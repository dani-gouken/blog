<?php


namespace Oxygen\Contracts\Providers;


interface SessionManagerContract
{
    public function get(string $key, $default = null);
    public function all():array;
    public function set(string $key, $value);
    public function unset(string $key);
    public function has(string $key):bool;
    public function regenerate();
    public function clear();

}
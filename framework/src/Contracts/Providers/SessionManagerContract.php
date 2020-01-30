<?php


namespace Oxygen\Contracts\Providers;


interface SessionManagerContract
{
    public function get(string $key);
    public function set(string $key, $value);
    public function unset(string $key);
    public function has(string $key);
    public function regenerate(string $key);

}
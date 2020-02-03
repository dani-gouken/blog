<?php


namespace Oxygen\Providers\Filesystem\Disks;


use League\Flysystem\AdapterInterface;
use Oxygen\Contracts\Providers\Filesystem\DiskContract;

class Local implements DiskContract
{
    /**
     * @var array
     */
    private $config;
    /**
     * @var string
     */
    private $path;

    /**
     * Local constructor.
     * @param array $config
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getAdapter(): AdapterInterface
    {
        return new \League\Flysystem\Adapter\Local($this->path);
    }

    public function getLabel(): string
    {
        return "local";
    }

    public function getConfig(): ?array
    {
        return $this->config;
    }
}
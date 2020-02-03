<?php


namespace Oxygen\Providers\Filesystem;


use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Filesystem\DiskContract;
use Oxygen\Contracts\ServiceProviderContract;

class DiskManagerProvider implements ServiceProviderContract
{
    /**
     * @var DiskContract[]
     */
    private $disks = [];

    public function __construct(array $disks)
    {
        $this->disks = $disks;
    }

    public function register(AppContract $app)
    {
        $app->getContainer()->set(DiskManager::class, new DiskManager($this->disks));
    }
}

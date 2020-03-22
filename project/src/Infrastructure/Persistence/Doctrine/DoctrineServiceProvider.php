<?php


namespace Infrastructure\Persistence\Doctrine;

use Infrastructure\Persistence\Doctrine\Repositories\DoctrinePostRepository;
use Domain\Repositories\PostRepository;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Providers\Database\Doctrine\DoctrineProvider;

class DoctrineServiceProvider implements ServiceProviderContract
{

    public function register(AppContract $app)
    {
        $app->use($app->getContainer()->get(DoctrineProvider::class));
        $app->getContainer()->set(PostRepository::class, $app->getContainer()->get(DoctrinePostRepository::class));
    }
}
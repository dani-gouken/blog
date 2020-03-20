<?php


namespace Infrastructure\Persistence\Doctrine\Repositories;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Domain\Entities\Post;
use Domain\Repositories\PostRepository;

class DoctrinePostRepository implements PostRepository
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Post $post
     * @return Post
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Post $post): Post
    {
        $this->em->persist($post);
        $this->em->flush();
        return $post;
    }

    /**
     * @param Post $post
     * @return Post
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Post $post): Post
    {
        $this->em->persist($post);
        $this->em->flush();
        return $post;
    }

    public function delete(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush();
    }

    public function find(int $id): Post
    {
        /**
         * @var $result Post
         */
        $result = $this->em->getRepository(Post::class)->find($id);
        return $result;
    }

    public function findAll(): array
    {
       return $this->em->getRepository(Post::class)->findAll();
    }

    public function findLatest(): array
    {
        // TODO: Implement findLatest() method.
    }
}
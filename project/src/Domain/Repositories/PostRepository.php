<?php


namespace Domain\Repositories;

use Domain\Entities\Post;

interface PostRepository
{

    public function create(Post $post):Post;
    public function update(Post $post):Post;
    public function delete(Post $post);
    public function find(int $id):Post;
    public function findAll():array;
    public function findLatest():array;

}
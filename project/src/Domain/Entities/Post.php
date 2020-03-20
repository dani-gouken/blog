<?php


namespace Domain\Entities;


use DateTime;

class Post
{
    public function __construct()
    {
        if($this->createdAt == null){
            $this->createdAt = new \DateTime();
        }
    }

    private $id;

    private $title;

    private $slug;

    private $content;

    private $createdAt;

    private $updatedAt;

    public function getId():int{
        return $this->id;
    }
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param mixed $createdAt
     * @return Post
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @param mixed $updatedAt
     * @return Post
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public static function newFromArray(array $data):Post{
        $post = new Post();
        $post->setTitle($data["title"]);
        $post->setContent($data["content"]);
        return $post;
    }

}
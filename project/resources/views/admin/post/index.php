<?php $this->layout("layout/admin") ?>
<?php
/**
 * @var $posts Domain\Entities\Post[]
 */
?>
<ul>
    <?php foreach ($posts as $post): ?>
        <li><?= $post->getTitle() ?> <a href="<?= $this->route("post.edit",["id"=>$post->getId()]) ?>">Edit</a> <a href="<?= $this->route("post.delete",["id"=>$post->getId()]) ?>">Delete</a></li>
    <?php endforeach; ?>
</ul>

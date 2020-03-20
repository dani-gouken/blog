<?php $this->layout("layout/admin") ?>
<?php
/**
 * @var $post \Domain\Entities\Post
 */
?>
<form action="<?= $this->route('post.edit',["id"=>$post->getId()]) ?>" method="POST">
    <?php if($errors = $this->flasher()->get("errors")) : ?>
        <?php foreach($errors as $error): ?>
            <?php foreach($error as $type => $message) : ?>
                <div class="alert alert-warning"><?= $message ?></div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $post->getTitle() ?>">
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" class="form-control"  rows="10"><?= $post->getContent() ?></textarea>
    </div>
    <div class="form-group">
        <div class="form-group">
            <label for="exampleFormControlFile1">Featured Image</label>
            <input type="file" name="featuredImage" class="form-control-file" id="featureImage">
        </div>
        <button class="btn btn-info" type="submit">UPDATE</button>
    </div>
</form>


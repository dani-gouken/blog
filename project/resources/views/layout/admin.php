<?php $this->layout("layout/front") ?>
<!-- Page Header -->
<header class="masthead" style="background-image: url('img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto py-5">
                <div class="py-5 text-center text-white">
                    <h1>Admin</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-4">
            <ul class="list-group">
                <li class="list-group-item"><a href="<?= $this->route("post.index") ?>">Posts</a></li>
                <li class="list-group-item"><a href="<?= $this->route("post.create") ?>">Créer un post</a></li>
            </ul>
        </div>
        <div class="col-8">
            <?= $this->section("content") ?>
        </div>
    </div>
</div>


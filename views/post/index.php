<?php
    use yii\widgets\LinkPager;
?>
<h1>My Posts</h1>

<div class="row">
    <div class="col-12">
        <?php if(count($model)) : ?>
            <?php foreach($model as $post) : ?>
                <div class="card mb-3 border-0">
                    <div class="row no-gutters">
                    <div class="col-md-2">
                        <img src="https://via.placeholder.com/600" class="card-img" alt="Placeholder">
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">
                        <h2 class="card-title"><a href="/post" class="text-decoration-none"><?=$post->title?></a></h2>
                        <p class="card-text"><?=$post->excerpt?></p>
                        <p class="card-text font-weight-light">Posted on <?=$post->date_created?></p>
                        </div>
                    </div>
                    </div>
                </div>
            <?php endforeach ?>

            <?=LinkPager::widget([
                'pagination' => $pages,
            ]);?>
        <?php else : ?>
            <div class="alert alert-info">
                You don't have any post yet! <a href="/post/create" class="alert-link">Create a post now</a>
            </div>
        <?php endif ?>
    </div>
</div>
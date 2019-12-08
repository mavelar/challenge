<?php
    use yii\helpers\Html;
    use yii\widgets\LinkPager;
?>
<h1><?=$author?"Posts by {$author->username}":'My Posts'?></h1>

<div class="row">
    <div class="col-8">
        <?php if(count($model)) : ?>
            <?php foreach($model as $post) : ?>
                <div class="card mb-3 border-0">
                    <?php if($post->image) : ?>
                        <img src="/uploads/<?=$post->image?>" class="card-img-top" alt="<?=$post->title?>">
                    <?php else : ?>
                        <img src="https://via.placeholder.com/1800x600?text=No Image" class="card-img-top" alt="Placeholder">
                    <?php endif ?>
                    <div class="card-body">
                        <h2 class="card-title"><?=Html::a($post->title, ['/post/'.$post->id], ['class' => 'text-decoration-none'])?></h2>
                        <p class="card-text"><?=$post->excerpt?></p>
                        <p class="card-text font-weight-light">Posted on <?=$post->date_created?></p>
                        <p><?=($post->author==Yii::$app->user->id?Html::a('Edit', ['/post/update', 'id' => $post->id]).' | '.Html::a('Delete', ['/post/delete', 'id' => $post->id], ['data-method' => 'post', 'data-confirm' => 'Are you sure to delete this post?', 'class' => 'text-danger']):'')?></p>
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
    <div class="col-4">
        <?php if($social) : ?>
            <a class="twitter-timeline" href="https://twitter.com/<?=$social->twitter?>?ref_src=twsrc%5Etfw">Tweets by <?=$social->twitter?></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        <?php endif ?>
    </div>
</div>